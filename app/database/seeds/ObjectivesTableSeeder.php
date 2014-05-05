<?php

class ObjectivesTableSeeder extends CsvSeeder {

public function __construct()
    {
        $this->table = 'objectives'; // Your database table name
        $this->filename = app_path().'/database/csv/objectives.csv'; // Filename and location of data in csv file
    }
}
