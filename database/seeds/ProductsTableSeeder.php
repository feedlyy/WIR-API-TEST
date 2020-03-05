<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->insert([
            'name' => 'tas',
            'stock' => 1,
            'price' => 55000
        ]);
        DB::table('products')->insert([
            'name' => 'baju',
            'stock' => 10,
            'price' => 25000
        ]);
    }
}
