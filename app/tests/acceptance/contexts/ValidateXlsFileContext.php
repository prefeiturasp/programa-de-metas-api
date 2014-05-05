<?php
use Behat\Behat\Event\ScenarioEvent;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Src\Importer\Parse;
use Src\Importer\Validator\Validator;
use Src\Importer\Validator\WorksheetGuide;

use    Way\Tests\Should;
use    Way\Tests\Assert;

class ValidateXlsFileContext extends BaseContext
{

    /**
     * @Given /^I have a spreadsheet loaded named "([^"]*)"$/
     */
    public function iHaveASpreadsheetLoadedNamed($filename)
    {
        $this->parseInstance = new Parse($filename);
        $this->validatorInstance = new Validator($this->parseInstance);
    }

    /**
     * @Given /^I have list of goals$/
     */
    public function iHaveListOfGoals()
    {
        $this->goals = $this->validatorInstance->getGoals();
        Assert::count(120, $this->goals);
    }

    /**
     * @When /^I validate the goals$/
     */
    public function iValidateTheGoals()
    {
        Assert::count(120, $this->validatorInstance->validateGoals($this->goals));
    }

    /**
     * @Then /^I should assert the length is not bigger than (\d+)$/
     */
    public function iShouldAssertTheLengthIsNotBiggerThan($maxLengthAllowed)
    {
        $data = $this->goals;
        $validData = $this->validatorInstance->validate('goal', 'name', $data);
        $columnLetter = WorksheetGuide::$availables['goal']['name'];

        foreach ($validData as $k => $value) {
            Assert::greaterThan(0, strlen($value[$columnLetter]));
            Assert::lessThanOrEqual($maxLengthAllowed, strlen($value[$columnLetter]));
        }
    }

    /**
     * @Then /^I should found multi secretaries acronym when a comma$/
     */
    public function iShouldFoundMultiSecretariesAcronymWhenAComma()
    {
        // TODO: must be able to especify wich rule validate
        $data = $this->goals;
        $validData = $this->validatorInstance->validate('goal', 'secretaries', $data);
        $columnLetter = WorksheetGuide::$availables['goal']['secretaries'];

        foreach ($validData as $value) {
            Assert::greaterThan(0, $value[$columnLetter]);
        }
    }

    /**
     * @Given /^I should be able to map secretary acronym to secretary register$/
     */
    public function iShouldBeAbleToMapSecretaryAcronymToSecretaryRegister()
    {
        $data = $this->goals;
        $validData = $this->validatorInstance->validate('goal', 'secretaries', $data);
        $columnLetter = WorksheetGuide::$availables['goal']['secretaries'];

        foreach ($validData as $value) {
            Assert::instance('Secretary', $value[$columnLetter][0]);
        }
    }

    /**
     * @Then /^I should be able to found valid status$/
     */
    public function iShouldBeAbleToFoundValidStatus()
    {
        $data = $this->goals;
        $validData = $this->validatorInstance->validate('goal', 'status', $data);
        $columnLetter = WorksheetGuide::$availables['goal']['status'];

        foreach ($validData as $value) {
            Assert::true(in_array($value[$columnLetter], array(1,2,3,4)));
        }
    }

    /**
     * @Given /^I have list of projects of type (\d+)$/
     */
    public function iHaveListOfProjectsOfType($projectType)
    {
        $this->projects = $this->validatorInstance->getProjectsByType($projectType);
        Assert::greaterThan(2, count($this->projects));
    }

    /**
     * @When /^I validate the project$/
     */
    public function iValidateTheProject()
    {
        //TODO: more verifications to certificate
        Assert::greaterThan(2, count($this->projects));
    }

    /**
     * @Then /^I should certificate goal exists$/
     */
    public function iShouldCertificateGoalExists()
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'goal_id', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'goal_id');

        foreach ($validData as $k => $value) {
            if (!is_null($value[$columnLetter])) {
                Assert::instance('Goal', $value[$columnLetter]);
            }
        }
    }

    /**
     * @Then /^I should certificate projects exists$/
     */
    public function iShouldCertificateProjectsExists()
    {
        // TODO: enable update over existing project beside create a new one
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'name', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'goal_id');
        foreach ($validData as $value) {
            //Assert::count(1, Project::where($value['goal_id']));
        }
        throw new PendingException('enable update over existing project beside create a new one');
    }

    /**
     * @Then /^I should assert the length of project name is not bigger than (\d+)$/
     */
    public function iShouldAssertTheLengthOfProjectNameIsNotBiggerThan($maxLengthAllowed)
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'name', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'name');
        foreach ($validData as $value) {
            Assert::lessThanOrEqual($maxLengthAllowed, strlen($value[$columnLetter]));
        }
    }

    /**
     * @Then /^I should be able to map a prefecture acronym to valid id$/
     */
    public function iShouldBeAbleToMapAPrefectureAcronymToValidId()
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'prefectures', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'prefectures');
        foreach ($validData as $value) {
            $prefectures = $value[$columnLetter];
            if (!is_null($prefectures)) {
                foreach ($prefectures as $prefecture) {
                    Assert::instance('Prefecture', $prefecture);
                }
            }
        }
    }

    /**
     * @Then /^I should be able to found a valid point on map$/
     */
    public function iShouldBeAbleToFoundAValidPointOnMap()
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'gps', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'gps');

        foreach ($validData as $value) {
            $gps = $value[$columnLetter];
            if (!empty($gps['lat'])) {
                Assert::true(Validator::isValidLatitude($gps['lat']));
            }
            if (!empty($gps['long'])) {
                Assert::true(Validator::isValidLatitude($gps['long']));
            }
        }
    }

    /**
     * @Then /^I should be able to found valid status at milestones$/
     */
    public function iShouldBeAbleToFoundValidStatusAtMilestones()
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'milestones', $data);
        $milestones = $this->validatorInstance->getColumnLetter('project', 'milestones');

        foreach ($validData as $row) {
            foreach ($milestones as $milestone) {
                if (!empty($row[$milestone])) {
                    Assert::true(in_array($row[$milestone], array(1,2,3,4)));
                }
            }
        }
    }

    /**
     * @Then /^Target goal values must be float and required$/
     */
    public function targetGoalValuesMustBeFloatAndRequired()
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'target_goal', $data);
        $columnLetter = $this->validatorInstance->getColumnLetter('project', 'target_goal');

        foreach ($validData as $value) {
            Assert::true(is_integer($value[$columnLetter]));
        }
    }

    /**
     * @Then /^I should be able to found valid values each month from (\d+) to (\d+)$/
     */
    public function iShouldBeAbleToFoundValidValuesEachMonthFromTo($arg1, $arg2)
    {
        $data = $this->projects;
        $validData = $this->validatorInstance->validate('project', 'months', $data);
        $months = $this->validatorInstance->getColumnLetter('project', 'months');

        foreach ($validData as $row) {
            foreach ($months as $month) {
                if (!empty($row[$month])) {
                    Assert::true(is_integer($row[$month]));
                }
            }
        }
    }
}
