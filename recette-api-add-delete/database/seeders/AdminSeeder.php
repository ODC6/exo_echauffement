<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('admin')->insert([
            "username" => "Marc0ka01",
            "email" => "example@gmail.com",
            "password" => bcrypt("123456789")
        ]);
    }
}
