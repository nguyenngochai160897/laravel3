<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "username" =>"admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("admin")
        ]);
    }
}
