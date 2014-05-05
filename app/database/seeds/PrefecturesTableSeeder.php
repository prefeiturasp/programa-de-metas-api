<?php

class PrefecturesTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'prefectures'; // Your database table name
        $this->filename = app_path().'/database/csv/prefectures.csv'; // Filename and location of data in csv file
    }
}
