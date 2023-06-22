<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::table('users')->truncate();
        DB::table('users')->insert([
            'master_user_type_id' => 1,
            'name' => 'Azam',
            'email' => 'azam.shaikh@littledoor.com',
            'api_token' => Str::random(60),
            'email_verified_at' => now(),
            'password' => Hash::make('Azam@123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'master_user_type_id' => 1,
            'name' => 'Shahbaz',
            'email' => 'shahbaz@littledoor.com',
            'api_token' => Str::random(60),
            'email_verified_at' => now(),
            'password' => Hash::make('Shahbaz@123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'master_user_type_id' => 1,
            'name' => 'Aquib',
            'email' => 'aquib.shaikh@littledoor.com',
            'api_token' => Str::random(60),
            'email_verified_at' => now(),
            'password' => Hash::make('Aquib@123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);



    }
}
