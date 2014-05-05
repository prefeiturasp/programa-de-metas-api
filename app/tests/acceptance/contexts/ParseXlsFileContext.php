<?php

use Behat\Behat\Context\ClosuredContextInterface;
use    Behat\Behat\Context\TranslatedContextInterface;
use    Behat\Behat\Context\BehatContext;
use    Behat\Behat\Exception\PendingException;

use    Behat\Gherkin\Node\PyStringNode;
use    Behat\Gherkin\Node\TableNode;

use    Way\Tests\Should;
use    Way\Tests\Assert;

use    Src\Importer\Parse;

class ParseXlsFileContext extends BaseContext
{

    protected $listWorksheet;
    protected $parseInstance;

    /**
     * @Given /^a opened file named "([^"]*)"$/
     */
    public function aOpenedFileNamed($filename)
    {
        $this->parseInstance = new Parse($filename);
    }

    /**
     * @Given /^There is a excel file loaded$/
     */
    public function thereIsAExcelFileLoaded()
    {
        Assert::instance('PHPExcel', $this->parseInstance->spreadsheet);
    }

    /**
     * @When /^I try to get all worksheet availables$/
     */
    public function iTryToGetAllWorksheetAvailables()
    {
        $this->listWorksheet = $this->parseInstance->getWorksheetsAvailable();

        $numberOfWorksheet = 13;
        Assert::count($numberOfWorksheet, $this->listWorksheet);
    }

    /**
     * @Then /^i should receive a list$/
     */
    public function iShouldReceiveAList(PyStringNode $expectedWorksheets)
    {
        Assert::equals($expectedWorksheets->getLines(), $this->listWorksheet);
    }

    /**
     * @Given /^the name of worksheet is "([^"]*)"$/
     */
    public function theNameOfWorksheetIs($wsName)
    {
        $this->parseInstance->setWorksheetActiveByName($wsName);
        Assert::equals($wsName, $this->parseInstance->getWorksheetNameActive());
    }

    /**
     * @When /^I try to get all meta available$/
     */
    public function iTryToGetAllMetaAvailable()
    {
        $this->listMetas = $this->parseInstance->getMetas();
        Assert::true(is_array($this->listMetas));
    }

    /**
     * @Then /^I should receive a list of metas$/
     */
    public function iShouldReceiveAListOfMetas()
    {
        Assert::count(36, $this->listMetas);
    }

    private function compareRequiredColumnsAndExpected($colummns, $requiredColummns)
    {
        $foundColummns = $missingColummns = array();
        foreach ($colummns as $colummn) {
            $foundColummns[] = $colummn;
        }

        $missingColummns = array_diff($requiredColummns, $foundColummns);

        Assert::equals($requiredColummns, $foundColummns);
        Assert::count(0, $missingColummns);
    }

    /**
     * @Given /^The meta must have the following colummns$/
     */
    public function theMetaMustHaveTheFollowingColummns(PyStringNode $colummns)
    {
        $this->compareRequiredColumnsAndExpected(
            $this->parseInstance->getColummnsOfMetas(),
            $colummns->getLines()
        );
    }

    /**
     * @When /^I try to get all projetcts available of type "([^"]*)"$/
     */
    public function iTryToGetAllProjetctsAvailableOfType($projectType)
    {
        $this->listProjects = $this->parseInstance->getProjectsByType($projectType);
        Assert::true(is_array($this->listProjects));
    }

    /**
     * @Then /^I should receive a list of projects$/
     */
    public function iShouldReceiveAListOfProjects()
    {
        Assert::count(119, $this->listProjects);
    }

       /**
     * @Given /^The projects of type "([^"]*)" must have the following colummns$/
     */
    public function theProjectsOfTypeMustHaveTheFollowingColummns($projectType, PyStringNode $colummns)
    {

        $this->compareRequiredColumnsAndExpected(
            $this->parseInstance->getColummnsOfProjectsByType($projectType),
            $colummns->getLines()
        );
    }
}
