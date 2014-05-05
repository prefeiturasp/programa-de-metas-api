<?php

class ArticulationsTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'articulations'; // Your database table name
        $this->filename = app_path().'/database/csv/articulations.csv'; // Filename and location of data in csv file
    }
}
