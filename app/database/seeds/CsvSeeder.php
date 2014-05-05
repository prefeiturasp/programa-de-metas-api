<?php

// - See more at: http://laravelsnippets.com/snippets/seeding-database-with-csv-files-cleanly#sthash.dXkQKEPI.dpuf

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CsvSeeder extends Seeder
{

    /**
    * DB table name
    *
    * @var string
    */
    protected $table;

    /**
    * CSV filename
    *
    * @var string
    */
    protected $filename;

    /**
    * Run DB seed
    */
    public function run()
    {
        //DB::table($this->table)->truncate();
        $seedData = $this->seedFromCSV($this->filename, ',');
        foreach($seedData as $ss) {
            DB::table($this->table)->insert($ss);
        }
    }

    /**
    * Collect data from a given CSV file and return as array
    *
    * @param $filename
    * @param string $deliminator
    * @return array|bool
    */
    private function seedFromCSV($filename, $deliminator = ",")
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $deliminator)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    if (count($row)>(count($header)/2)) {
                        $row = array_pad($row, count($header), 0);
                    }
                    //var_dump($row);
                    $data[] = array_combine($header, $row);

                }
            }
            fclose($handle);
        }
        return $data;
    }
}
