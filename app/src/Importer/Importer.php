<?php

namespace Src\Importer;

use Src\Importer\Validator\Validator;
use Src\Importer\Validator\WorksheetGuide;
use Illuminate\Support\Facades\File;

use DB;
use ProjectMilestone;
use ProjectMonthlyProgress;
use Goal;
use Project;

class Importer
{
    public $validator;
    public $parse;
    public $defaultPath;

    public function __construct($filename = null)
    {
        $this->defaultPath = app_path() . "/storage/importer";
    }

    public function isContentParsed()
    {
        if ((!is_null($this->parse)) && ($this->parse instanceof Parse)) {
            return true;
        }

        return false;
    }

    public function getParse()
    {
        if ($this->isContentParsed()) {
            return $this->parse;
        }

        return false;
    }

    public function parse($filename)
    {
        if (!$this->isContentParsed()) {
            $this->parse = new Parse($filename);
        }

        return $this->parse;
    }

    public function getValidator()
    {
        if (is_null($this->validator)) {
            return new Validator($this->getParse());
        } else {
            return $this->validator;
        }
    }

    public function getAvailableFilenames()
    {
        return File::files($this->defaultPath);
    }

    public function getValidGoals()
    {
        $this->validator = $this->getValidator();
        return $this->validator->validateGoals($this->validator->getGoals());
    }

    public function saveGoals()
    {
        try {
            $validateGoals = $this->getValidGoals();
            foreach ($validateGoals as $goal) {

                $Id               = $goal[WorksheetGuide::$availables['goal']['id']];
                $Name             = $goal[WorksheetGuide::$availables['goal']['name']];
                $Secretaries      = $goal[WorksheetGuide::$availables['goal']['secretaries']];
                $Status           = $goal[WorksheetGuide::$availables['goal']['status']];
                $Transversalidade = $goal[WorksheetGuide::$availables['goal']['transversalidade']];
                $Qualitative1     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_1']];
                $Qualitative2     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_2']];
                $Qualitative3     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_3']];
                $Qualitative4     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_4']];
                $Qualitative5     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_5']];
                $Qualitative6     = $goal[WorksheetGuide::$availables['goal']['qualitative_progress_6']];

                $Goal = Goal::find($Id);
                if (!is_null($Goal)) {
                    $Goal->name                       = $Name;
                    $Goal->status                     = $Status;
                    $Goal->transversalidade           = $Transversalidade;
                    $Goal->qualitative_progress_1     = $Qualitative1;
                    $Goal->qualitative_progress_2     = $Qualitative2;
                    $Goal->qualitative_progress_3     = $Qualitative3;
                    $Goal->qualitative_progress_4     = $Qualitative4;
                    $Goal->qualitative_progress_5     = $Qualitative5;
                    $Goal->qualitative_progress_6     = $Qualitative6;
                    $Goal->save();

                    // BUG: DUPLICATE RELATIONSHIP WHEN YET EXISTS
                    foreach ($Secretaries as $Secretary) {
                        if (!is_null($Secretary)) {
                            //var_dump($Secretary->name);
                            $Goal->secretaries()->save($Secretary);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
        return true;
    }

    public function getChanges()
    {
        return array();
    }

    public function getValidProjectsOfType($type)
    {
        $this->validator = $this->getValidator();
        return $this->validator->validateProjects($this->validator->getProjectsByType($type));
    }

    public function saveProjectsOfType($validProjects, $type)
    {
        try {
            $changes = array();
            foreach ($validProjects as $project) {
                if (!empty($project[WorksheetGuide::$availables['project'][$type]['name']])) {

                    $Name            = $project[WorksheetGuide::$availables['project'][$type]['name']];
                    $Prefectures     = $project[WorksheetGuide::$availables['project'][$type]['prefectures']];
                    $GoalId          = $project[WorksheetGuide::$availables['project'][$type]['goal_id']];
                    $Project         = Project::findByNameAndType($Name, $type);

                    if (!($Project instanceof Project)) {
                        $WeightAboutGoal = $project[WorksheetGuide::$availables['project'][$type]['weight_about_goal']];
                        $BudgetExecuted  = $project[WorksheetGuide::$availables['project'][$type]['budget_executed']];
                        $Qualitative1    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_1']];
                        $Qualitative2    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_2']];
                        $Qualitative3    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_3']];
                        $Qualitative4    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_4']];
                        $Qualitative5    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_5']];
                        $Qualitative6    = $project[WorksheetGuide::$availables['project'][$type]['qualitative_progress_6']];
                        $Location        = $project[WorksheetGuide::$availables['project'][$type]['location_type']];

                        $extraFields = array();
                        if (($type > 0) && ($type < 6)) {
                            $extraFields = array(
                                'district' => $project[WorksheetGuide::$availables['project'][$type]['district']],
                                'address'  => $project[WorksheetGuide::$availables['project'][$type]['address']]
                            );
                            if (is_array($project[WorksheetGuide::$availables['project'][$type]['gps']])) {
                                $extraFields['gps_lat'] = $project[WorksheetGuide::$availables['project'][$type]['gps']]['lat'];
                                $extraFields['gps_long'] = $project[WorksheetGuide::$availables['project'][$type]['gps']]['long'];
                            }
                        } elseif ($type == 6) {
                            $extraFields = array(
                                'district' => $project[WorksheetGuide::$availables['project'][$type]['district']]
                            );
                        } elseif ($type == 7) {
                            $extraFields = array(
                                'district' => $project[WorksheetGuide::$availables['project'][$type]['district']]
                            );
                        } elseif ($type == 8) {
                            $extraFields = array(
                                'district' => $project[WorksheetGuide::$availables['project'][$type]['district']],
                                'address'  => $project[WorksheetGuide::$availables['project'][$type]['address']]
                            );

                            if (is_array($project[WorksheetGuide::$availables['project'][$type]['gps']])) {
                                $extraFields['gps_lat'] = $project[WorksheetGuide::$availables['project'][$type]['gps']]['lat'];
                                $extraFields['gps_long'] = $project[WorksheetGuide::$availables['project'][$type]['gps']]['long'];
                            }
                        }

                        if (isset($GoalId->id)) {
                            $goal_id = $GoalId->id;
                        } else {
                            $goal_id = 1;
                        }

                        $Project = Project::create(
                            array_merge(
                                array(
                                    'name'                   => $Name,
                                    'goal_id'                => $goal_id,
                                    'weight_about_goal'      => $WeightAboutGoal,
                                    'budget_executed'        => $BudgetExecuted,
                                    'project_type'           => $type,
                                    'qualitative_progress_1' => $Qualitative1,
                                    'qualitative_progress_2' => $Qualitative2,
                                    'qualitative_progress_3' => $Qualitative3,
                                    'qualitative_progress_4' => $Qualitative4,
                                    'qualitative_progress_5' => $Qualitative5,
                                    'qualitative_progress_6' => $Qualitative6,
                                    'location_type'          => $Location
                                ),
                                $extraFields
                            )
                        );
                    }

                    $project_id = $Project->id;
                    $changes[] = $Project->id;

                    if (($type > 0) && ($type < 8)) {
                        $this->saveMilestones($project_id, $project);
                    } elseif ($type == 8) {
                        $this->saveMonths($project_id, $project);
                    }

                    // BUG: DUPLICATE RELATIONSHIP WHEN YET EXISTS
                    if (isset($Prefectures)) {
                        if (is_array($Prefectures)) {
                            foreach ($Prefectures as $Prefecture) {
                                //if ((!is_null($Prefecture)) && (is_object($Prefecture))){
                                if (!is_null($Prefecture)) {
                                    //var_dump($Prefecture);
                                    $Project->prefectures()->save($Prefecture);
                                }
                            }
                        }
                    }
                    unset($Project);
                }
            }
        } catch (Exception $e) {
            Log::warning("ERRO AO TENTAR SALVAR PROJETOS: " . $e->getMessage());
            return false;
        }
        return true;
    }

    protected function saveMilestones($project_id, $project)
    {
        $sourceProject = Project::findOrFail($project_id);
        //var_dump($project);
        $milestones = WorksheetGuide::$availables['project'][$sourceProject->project_type]['milestones'];
        $prefectures = $project[WorksheetGuide::$availables['project'][$sourceProject->project_type]['prefectures']];

        foreach ($milestones as $currentMilestone => $columnLetter) {
            try {
                if (isset($prefectures[0])) {
                    if (is_null($project[$columnLetter])) {
                        var_dump($milestones, $project);
                    }
                    ProjectMilestone::create(
                        array(
                        'project_id' => $project_id,
                        'prefecture_id' => $prefectures[0]->id,
                        'milestone' => $currentMilestone,
                        'status' => $project[$columnLetter]
                        )
                    );
                } else {
                    var_dump($prefectures);
                }
            } catch (Exception $e) {
                throw new Exception("Error when tryng to save milestones: ".$this->implode_r($project), 1);
            }
        }
    }

    protected function saveMonths($project_id, $project)
    {
        $projectType = 8;
        $prefectures = $project[WorksheetGuide::$availables['project'][$projectType]['prefectures']];
        $goal_target = $project[WorksheetGuide::$availables['project'][$projectType]['goal_target']];
        $monthsYears = WorksheetGuide::$availables['project'][$projectType]['months'];

        DB::disableQueryLog();

        foreach ($monthsYears as $monthYear => $columnLetter) {
            ProjectMonthlyProgress::create(
                array(
                'project_id' => $project_id,
                'prefecture_id' => $prefectures[0]->id,

                'goal_target' => $goal_target,
                'month_year' => $monthYear,
                'value' => $project[$columnLetter]
                )
            );
        }
    }
}
