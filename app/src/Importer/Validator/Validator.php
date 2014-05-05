<?php
namespace Src\Importer\Validator;
use Log;
use Secretary;
use Goal;
use Prefecture;

use Src\Importer\Validator\Rules;
use Src\Importer\Validator\WorksheetGuide;

use Src\Importer\Parse;

use Str;

class Validator
{

    public static $MILESTONE_STATUS = array(
        'c'  => 100,
        'ea' => 50,
        'ni' => 1
        );

    public static $META_STATUS = array(
        'superada'                                => 5,
        'concluída'                               => 4,
        'em andamento com benefícios à população' => 3,
        'em andamento'                            => 2,
        'não iniciada'                            => 1
    );

    protected $projectType;

    public $parseInstance;

    public function __construct(Parse $parse)
    {
        $this->parseInstance = $parse;
    }

    public function getGoals()
    {
        return $this->parseInstance->getMetas();
    }

    public function getProjectsByType($typeProject)
    {
        $this->setProjectType($typeProject);

        return $this->parseInstance->getProjectsByType($typeProject);
    }

    public function validateGoals($goals)
    {
        $validGoals = $goals;
        foreach (Rules::$rules['goal'] as $field => $rule) {
            $validGoals = $this->validate('goal', $field, $validGoals);
        }

        return $validGoals;
    }

    public function validateProjects($projects)
    {
        $validProjects = $projects;
        foreach (Rules::$rules['project'][$this->getProjectType()] as $field => $rule) {
            $validProjects = $this->validate('project', $field, $validProjects);
        }

        return $validProjects;
    }

    protected function setProjectType($projectType)
    {
        $this->projectType = $projectType;
    }
    public function getProjectType()
    {
        return $this->projectType;
    }

    protected function getRules($type, $field)
    {
        if ($type === 'goal') {
            return Rules::$rules[$type][$field];
        } else {
            return Rules::$rules[$type][$this->getProjectType()][$field];
        }
    }

    // goal, name, array
    public function validate($type, $field, $data)
    {

        $validData = $data;
        $rule = $this->getRules($type, $field);
        if (is_array($rule)) {
            foreach ($rule as $ruleName) {
                $validData = $this->baseRule($type, $field, $validData, $ruleName);
            }
        } else {
            $validData = $this->baseRule($type, $field, $validData, $rule);
        }
        return $validData;
    }

    public function getColumnLetter($type, $field)
    {
        if ($type === 'goal') {
            return WorksheetGuide::$availables[$type][$field];
        } else {
            return WorksheetGuide::$availables[$type][$this->getProjectType()][$field];
        }
    }

    public function baseRule($type, $field, $data, $ruleName)
    {
        $validData = array();

        foreach ($data as $k => $row) {
            if (is_null($row)) {
                unset($data[$k]);
            } else {
                try {
                    if ($field == 'milestones') {
                        $validated = $this->validateRowAsMilestone($type, $field, $row, $ruleName);
                    } elseif ($field == 'months') {
                        $validated = $this->validateRowAsMonthlyProgress($type, $field, $row, $ruleName);
                    } else {
                        $validated = $this->validateRow($type, $field, $row, $ruleName);
                    }
                    $validData[] = $validated;
                } catch (\Exception $e) {
                    unset($data[$k]);
                    Log::warning($e->getMessage(), array('context'=>array($type,$this->getProjectType(),$field,$k)));
                }
            }
        }
        return $validData;
    }

    protected function validateRowAsMonthlyProgress($type, $field, $row, $ruleName)
    {
        $validData = $row;
        $months = $this->getColumnLetter($type, $field);

        foreach ($months as $month) {
            if (!empty($row[$month])) {
                $validData[$month] = $this->validFloatNumber($row[$month]);
            }
        }

        return $validData;
    }

    protected function validateRowAsMilestone($type, $field, $row, $ruleName)
    {
        $milestones = $this->getColumnLetter($type, $field);

        foreach ($milestones as $milestone) {
            if ((array_key_exists($milestone, $row))) {
                try {
                    $row[$milestone] = $this->getValidMilestoneStatus($row[$milestone]);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage(), 1);
                }
            }
        }
        return $row;
    }

    protected function validateRow($type, $field, $row, $ruleName)
    {
        $columnLetter = $this->getColumnLetter($type, $field);

        if ((array_key_exists($columnLetter, $row))) {
            try {
                $row[$columnLetter] = $this->$ruleName($row[$columnLetter]);
            } catch (Exception $e) {
                throw new \Exception($e->getMessage(), 1);
            }
        }
        return $row;
    }

    protected function getValidMilestoneStatus($value)
    {
        if (empty($value)) {
            return self::$MILESTONE_STATUS['ni']; // não iniciado
        } elseif (array_key_exists(strtolower($value), self::$MILESTONE_STATUS)) {
            return self::$MILESTONE_STATUS[strtolower($value)];
        }
        return self::$MILESTONE_STATUS['ni']; // não iniciado
    }

    public function stringLowerThan350($value)
    {
        if (strlen($value) <= 350) {
            return $value;
        }

        throw new \Exception("Invalid {$value} length, exceed max allowed.", 1);
    }

    public function splitContentByComma($value)
    {
        $value = trim($value);

        if (empty($value)) {
            return '';
        } elseif (strstr($value, ",")) {
            return explode(",", $value);
        } else {
            return array($value);
        }
    }

    public function getSecretaryRegisteredId($value)
    {
        $secretaries = array();
        if (is_array($value)) {
            foreach ($value as $acronym) {
                $secretaries[] = Secretary::findByAcronym(trim($acronym));
            }
        } elseif (!empty($value)) {
            $secretaries[] = Secretary::findByAcronym(trim($value));
        } else {
            throw new \Exception("Secretary is required, empty value found", 1);
        }

        if (count($secretaries[0]) > 0) {
            return $secretaries;
        }

        throw new \Exception(
            "Not found valid Secretary with: ".(is_array($value) ? implode(",", $value) : $value),
            1
        );
    }

    protected function getValidStatus($value)
    {
        if (empty($value)) {
            throw new \Exception("Meta Status is a required field", 1);
        } elseif (isset(self::$META_STATUS[Str::lower($value)])) {
            return self::$META_STATUS[Str::lower($value)];
        }

        throw new \Exception("Invalid Meta Status {$value}", 1);
    }

    public function getGoalRegisteredId($value)
    {
        if (empty($value)) {
            throw new \Exception("Id Goal is required", 1);
        }

        $goal = Goal::find($value);
        if (is_object($goal)) {
            return $goal;
        }

        throw new \Exception("Invalid Meta number {$value}", 1);
    }

    public function stringLowerThan255($value)
    {
        $value = trim($value);

        if (strlen($value) <= 255) {
            return $value;
        }

        throw new \Exception("Invalid ({$value}) length, exceed max allowed.", 1);
    }

    public function getPrefectureRegisteredId($value)
    {
        $prefectures = array();
        if (is_array($value)) {
            foreach ($value as $name) {
                $prefecture = Prefecture::findByName($name);
                if (is_object($prefecture)) {
                    $prefectures[] = $prefecture;
                } else {
                    throw new \Exception("One or more prefecture(s) was not found: {$name}", 1);
                }
            }
            return $prefectures;
        } elseif (!empty($value)) {
            $prefecture = Prefecture::findByName($value);
            if (is_object($prefecture)) {
                return array($prefecture);
            } else {
                throw new \Exception("Prefecture not found: {$value}", 1);
            }
        } else {
            throw new \Exception("Prefecture is required, project ignored.", 1);
        }
    }

    public function validateCoordinates($value)
    {
        if (is_null($value)) {
            return array('lat'=>0, 'long'=>0);
        }

        if (count($value) == 2) {
            $lat = trim($value[0]);
            $long = trim($value[1]);
            if (self::isValidLatitude($lat) && self::isValidLongitude($long)) {
                return array('lat' => $lat, 'long' => $long);
            }
        }

        return array('lat'=>0, 'long'=>0);
    }

    public static function isValidLatitude($latitude)
    {
        if (preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/", $latitude)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidLongitude($longitude)
    {
        if (preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/", $longitude)) {
            return true;
        } else {
            return false;
        }
    }

    public function validPercentage($number)
    {

        if (empty($number)) {
            return 0;
        }
        $number = trim($number);

        return $number;

        throw new \Exception("Invalid ({$number}), must be a valid integer.", 1);
    }

    public function validFloatNumber($number)
    {
        if (empty($number)) {
            return '';
        }
        $number = str_replace("'", "", $number);
        $number = str_replace(",", "", $number);

        return $number;

        throw new \Exception("Invalid ({$number}), must be a valid float.", 1);
    }

    private function implode_r($glue, $arr)
    {
        $ret_str = "";
        foreach ($arr as $a) {
                $ret_str .= (is_array($a)) ? $this->implode_r($glue, $a) : "," . $a;
        }
        return $ret_str;
    }
}
