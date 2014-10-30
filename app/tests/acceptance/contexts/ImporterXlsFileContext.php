<?php

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Src\Importer\Importer;
use Src\Importer\Validator;

use  Way\Tests\Should;
use  Way\Tests\Assert;

class ImporterXlsFileContext extends BaseContext
{

    public $importerInstance;

    public function __construct()
    {
        $this->importerInstance = new Importer;
    }

    /**
     * @Given /^i have a default directory "([^"]*)"$/
     */
    public function iHaveADefaultDirectory($defaultDirectory)
    {
        Should::contain($defaultDirectory, $this->importerInstance->defaultPath);
    }

    /**
     * @Given /^i haven`t a filename$/
     */
    public function iHavenTAFilename()
    {
        Assert::true(!$this->importerInstance->isContentParsed());
    }

    /**
     * @When /^i try to list my available options$/
     */
    public function iTryToListMyAvailableOptions()
    {
        $this->availableFilenames = $this->importerInstance->getAvailableFilenames();
        Assert::count(12, $this->availableFilenames);
    }

    /**
     * @Then /^i should recieve a list of filenames$/
     */
    public function iShouldRecieveAListOfFilenames(PyStringNode $expectedListOfFilenames)
    {
        foreach ($expectedListOfFilenames as $expectedFilename) {
            Assert::contain($expectedFilename, $this->availableFilenames);
        }
    }

/**
     * @Given /^i have a parsed content "([^"]*)"$/
     */
    public function iHaveAParsedContent($filename)
    {
        $this->importerInstance->parse($filename);
        Assert::true($this->importerInstance->isContentParsed());
        Assert::instance('Src\Importer\Parse', $this->importerInstance->parse($filename));
    }

    /**
     * @Given /^i have validate goals$/
     */
    public function iHaveValidateGoals()
    {
        $this->validGoals = $this->importerInstance->getValidGoals();
        Assert::count(123, $this->validGoals);
    }

    /**
     * @When /^i try to save goals to database$/
     */
    public function iTryToSaveGoalsToDatabase()
    {
        Assert::true($this->importerInstance->saveGoals($this->validGoals));

        // TODO: verificar se não tem nada no log
    }

    /**
     * @Then /^i should receive a list of successfull changes$/
     */
    public function iShouldReceiveAListOfSuccessfullChanges()
    {
        Assert::count(1, $this->importerInstance->getChanges());
    }

    /**
     * @Given /^i have validate projects of type (\d+)$/
     */
    public function iHaveValidateProjectsOfType($projectType)
    {
        $this->validProjects = $this->importerInstance->getValidProjectsOfType($projectType);
        //Assert::greaterThans(2, $this->validProjects);
    }

    /**
     * @When /^i try to save projects of type (\d+) to database$/
     */
    public function iTryToSaveProjectsOfTypeToDatabase($projectType)
    {
        Assert::true($this->importerInstance->saveProjectsOfType($this->validProjects, $projectType));
    }
}
