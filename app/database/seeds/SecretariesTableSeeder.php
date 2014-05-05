<?php

class SecretariesTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'secretaries'; // Your database table name
        $this->filename = app_path().'/database/csv/secretaries.csv'; // Filename and location of data in csv file
    }
}
