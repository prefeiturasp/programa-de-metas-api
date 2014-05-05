<?php

class GoalsTableSeeder extends CsvSeeder {

public function __construct()
    {
        $this->table = 'goals'; // Your database table name
        $this->filename = app_path().'/database/csv/goals.csv'; // Filename and location of data in csv file
    }
}
