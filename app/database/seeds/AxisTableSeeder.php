<?php

class AxisTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'axes'; // Your database table name
        $this->filename = app_path().'/database/csv/axes.csv'; // Filename and location of data in csv file
    }
}
