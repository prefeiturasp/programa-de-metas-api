<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('SecretariesTableSeeder');
        $this->command->info('Secretaries table seeded!');

        $this->call('ObjectivesTableSeeder');
        $this->command->info('Objectives table seeded!');

        $this->call('AxisTableSeeder');
        $this->command->info('Axis table seeded!');

        $this->call('ArticulationsTableSeeder');
        $this->command->info('Articulations table seeded!');

        $this->call('PrefecturesTableSeeder');
        $this->command->info('Prefectures table seeded!');

        $this->call('GoalsTableSeeder');
        $this->command->info('Goals table seeded!');
    }

}
