<?php

namespace Src\Importer;
use \Src\Importer\Read;
class Parse
{
    static public $nameofWorksheetOfMeta           = 'Status_metas';
    static public $nameofWorksheetOfProjetoDoTipo = array(
        1 => 'Status tipo 1',
        2 => 'Status tipo  2',
        3 => 'Status tipo 3',
        4 => 'Status tipo 4',
        5 => 'Status tipo 5',
        6 => 'Status tipo 6',
        7 => 'Status tipo 7',
        8 => 'Status tipo 8');

    public $spreadsheet;

    protected $fileReader;

    public function __construct($filename)
    {

        try {
            $this->fileReader = Read::getInstance();
            $this->spreadsheet = $this->fileReader->openFile($filename);

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }

    public function getWorksheetsAvailable ()
    {
        $worksheetData = $this->fileReader->excelReader->listWorksheetInfo($this->fileReader->getFile());
        $availableWorksheets = array();
        foreach ($worksheetData as $worksheet) {
            $availableWorksheets[] = $worksheet['worksheetName'];
        }

        return $availableWorksheets;
    }

    public function setWorksheetActiveByName($name)
    {
        return $this->spreadsheet->setActiveSheetIndexByName($name);
    }

    public function getWorksheetNameActive()
    {
        return $this->spreadsheet->getSheet($this->spreadsheet->getActiveSheetIndex())->getTitle();
    }

    public function getWorksheetByName($name)
    {
        return $this->fileReader->getSpreadsheet()->getSheetByName($name);
    }

    public function getColummns($objWorksheet)
    {
        $objWorksheet = $this->spreadsheet->getActiveSheet();

        foreach ($objWorksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            foreach ($cellIterator as $cell) {
                $colummns[] =  trim(preg_replace('/\s+/', ' ', $cell->getValue()));
            }
            break; // get only first row, colummn name
        }
        return $colummns;
    }

    public function getCells($objWorksheet)
    {
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $colummns = array();
        for ($col = 0; $col <= $highestColumnIndex; ++$col) {
            $colummns[] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
        }
        return $colummns;
    }

    public function getMetas()
    {
        $this->setWorksheetActiveByName(self::$nameofWorksheetOfMeta);
        return array_slice($this->spreadsheet->getActiveSheet()->toArray(null, true, true, true), 1);
    }

    public function getColummnsOfMetas()
    {
        $this->setWorksheetActiveByName(self::$nameofWorksheetOfMeta);
        return $this->getColummns($this->spreadsheet->getActiveSheet());
    }

    public function getProjectsByType($type)
    {
        $this->setWorksheetActiveByName(self::$nameofWorksheetOfProjetoDoTipo[$type]);
        $spreadsheet = $this->spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // try to cleanup empty rows
        foreach ($spreadsheet as $row) {
            $rowIsValid = false;
            for ($i=0; $i<=count($row); $i++) {
                //if (!empty($row[])) {}
            }
        }

        return array_slice($spreadsheet, 1);
    }

    public function getColummnsOfProjectsByType($type)
    {
        $this->setWorksheetActiveByName(self::$nameofWorksheetOfProjetoDoTipo[$type]);
        return $this->getColummns($this->spreadsheet->getActiveSheet());
    }
}
