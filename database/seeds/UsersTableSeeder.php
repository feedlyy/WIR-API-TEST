<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Fadli',
            'email' => 'fadli@gmail.com',
            'password' => bcrypt('testing123'),
            'role' => 'merchant'
        ]);
        DB::table('users')->insert([
            'name' => 'testing',
            'email' => 'testing@gmail.com',
            'password' => bcrypt('testing123'),
            'role' => 'costumer',
            'balance' => 100000,
            'point' => 5
        ]);
    }
}
