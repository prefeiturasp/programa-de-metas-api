<?php

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class LoadDataFromSpreadsheetContext extends BaseContext
{

    public function __construct()
    {
    }

    /**
     * @Given /^i have a CommandImporter$/
     */
    public function iHaveACommandimporter()
    {
        throw new PendingException();
    }

    /**
     * @When /^i execute the command without parameters$/
     */
    public function iExecuteTheCommandWithoutParameters()
    {
        throw new PendingException();
    }

    /**
     * @Then /^i should recieve a list of filenames availables$/
     */
    public function iShouldRecieveAListOfFilenamesAvailables()
    {
        throw new PendingException();
    }

    /**
     * @Given /^i have a "([^"]*)" task$/
     */
    public function iHaveATask($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^i execute the command with following parameters "([^"]*)" and values "([^"]*)"$/
     */
    public function iExecuteTheCommandWithFollowingParametersAndValues($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then /^i should receive a list of meta changes$/
     */
    public function iShouldReceiveAListOfMetaChanges()
    {
        throw new PendingException();
    }

    /**
     * @When /^i execute the command with following parameters "([^"]*)" and value "([^"]*)"$/
     */
    public function iExecuteTheCommandWithFollowingParametersAndValue($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^i should to be able to count projects by type imported$/
     */
    public function iShouldToBeAbleToCountProjectsByTypeImported(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then /^i should be able to count "([^"]*)" metas and total of projects by type$/
     */
    public function iShouldBeAbleToCountMetasAndTotalOfProjectsByType($arg1, TableNode $table)
    {
        throw new PendingException();
    }
}
