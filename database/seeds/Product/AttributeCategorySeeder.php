<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 50; $i++)
        {
            DB::table('attribute_category')
                ->insert([
                    'attribute_id' => $i,
                    'category_id' => $i,
                ]);
        }
    }
}
