<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Hot Drinks',
            'color' => '#E66565'
        ]);

        DB::table('categories')->insert([
            'name' => 'Cold Drinks',
            'color' => '#7DD7E3'
        ]);

        DB::table('categories')->insert([
            'name' => 'Sweet Food',
            'color' => '#E693DF'
        ]);

        DB::table('categories')->insert([
            'name' => 'Savoury Food',
            'color' => '#93E69A'
        ]);

        DB::table('categories')->insert([
            'name' => 'Bottled Drinks',
            'color' => '#65EBD4'
        ]);
    }
}
