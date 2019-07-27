<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'users',
        'countries',
        'states',
        'cities',
        'categories',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {           
        /** clear database before seeding */
        DB::statement('set foreign_key_checks=0');

        foreach($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        $this->call(UserSeeder::class);

        /** country,state,city */
        $this->call(CountryStateCitySeeder::class);

        $this->call(CategorySeeder::class);
    }
}
