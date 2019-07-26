<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert(['name' => 'Iran']);

        $content = file_get_contents(base_path('resources/Province.json'));

        $data = json_decode($content, true);

        foreach($data as $item)
        {
            $id = DB::table('states')->insertGetId(['name' => $item['name'], 'country_id' => 1]);

            foreach($item['Cities'] as $city)
            {
                DB::table('cities')->insert(['name' => $city['name'], 'state_id' => $id]);
            }
        }
    }
}
