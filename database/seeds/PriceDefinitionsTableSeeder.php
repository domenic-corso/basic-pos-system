<?php

use Illuminate\Database\Seeder;

class PriceDefinitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('price_definitions')->insert([
            'small' => '3.8',
            'regular' => '4.1',
            'large' => '4.5'
        ]);

        DB::table('price_definitions')->insert([
            'small' => '4.2',
            'regular' => '4.8',
            'large' => '5.4'
        ]);

        DB::table('price_definitions')->insert([
            'small' => '4.6',
            'regular' => '5.4',
            'large' => '5.8'
        ]);

        DB::table('price_definitions')->insert([
            'small' => '5.6',
            'regular' => '6.2',
            'large' => '6.8'
        ]);
    }
}
