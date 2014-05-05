<?php

namespace Src\Importer;

use Illuminate\Support\Facades\File;

class Read
{

    protected $filename;
    protected $spreadsheet;
    public $excelReader;
    public $path;

    private static $instance;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!Read::$instance instanceof self) {
             Read::$instance = new self();
        }
        return Read::$instance;
    }

    public function openFile ($filename)
    {
        if (!$this->isValidSpreadsheet()) {
            try {
                $inputFileName = $this->setFile($filename);

                $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
                $this->excelReader = \PHPExcel_IOFactory::createReader($inputFileType);

                $spreadsheet = $this->excelReader->load($inputFileName);
                $this->setSpreadsheet($spreadsheet);

                return $spreadsheet;

            } catch (Exception $e) {
                throw new \Exception($e->getMessage(), 1);
            }
        }

        return $this->getSpreadsheet();
    }

    public function setFile ($filename)
    {
        $this->path = app_path() . '/storage/importer/';

        if (File::exists($this->path . $filename)) {
            $this->filename = $filename;

            return $this->path . $filename;
        }

        throw new \Exception("Can not open, file not found", 1);
    }

    public function getFile ()
    {
        if (!empty($this->filename)) {
            return $this->path . $this->filename;
        }

        throw new \Exception("Filename could not be null", 1);
    }

    public function setSpreadsheet($spreadsheet)
    {
        return $this->spreadsheet = $spreadsheet;
    }

    public function getSpreadsheet()
    {
        if ($this->isValidSpreadsheet()) {
            return $this->spreadsheet;
        }

        return false;
    }

    protected function isValidSpreadsheet()
    {
        if (is_object($this->spreadsheet)) {
            return true;
        }

        return false;
    }
}
