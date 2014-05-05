<?php


use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Way\Tests\Should;
use Way\Tests\Assert;
use Src\Importer\Read;

class ReadXlsFileContext extends BaseContext
{

    protected $instance;
    protected $path_filename;

    public function __construct()
    {
        $this->instance = Read::getInstance();
    }

    /**
     * @Given /^There is a default directory to search files$/
     */
    public function thereIsADefaultDirectoryToSearchFiles()
    {
        Should::beTrue($this->instance instanceof Read);
    }

    /**
     * @When /^I try to found a file named "([^"]*)"$/
     */
    public function iTryToFoundAFileNamed($filename)
    {

        $this->exceptionMessage = null;
        try {
            $this->path_filename = $this->instance->setFile($filename);
        } catch (\Exception $e) {
            $this->exceptionMessage = $e->getMessage();
        }
    }

    /**
     * @Given /^I should throw a exception "([^"]*)"$/
     */
    public function iShouldThrowAException($message)
    {
        Assert::equals($message, $this->exceptionMessage);
    }

    /**
     * @Then /^I should get complete path of file$/
     */
    public function iShouldGetCompletePathOfFile()
    {
        Assert::equals($this->path_filename, $this->instance->getFile());
    }

    /**
     * @Given /^I try to open a file named "([^"]*)"$/
     */
    public function iTryToOpenAFileNamed($filename)
    {
        $this->instance->openFile($filename);
    }

    /**
     * @Given /^I load as excel content$/
     */
    public function iLoadAsExcelContent()
    {
        Assert::instance('PHPExcel', $this->instance->getSpreadsheet());
    }

    /**
     * @When /^I try to read column one and cell one$/
     */
    public function iTryToReadColumnOneAndCellOne()
    {
        $this->worksheet = $this->instance->getSpreadsheet()->getActiveSheet()->toArray(null, true, true, true);
    }

    /**
     * @Then /^I should get "([^"]*)"$/
     */
    public function iShouldGet($content)
    {
        Assert::equals($content, $this->worksheet[1]['A']);
    }
}
