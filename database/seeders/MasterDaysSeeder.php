<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_days')->truncate();
        DB::table('master_days')->insert([
            'name' => 'Monday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Tuesday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Wednesday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Thursday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Friday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Saturday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_days')->insert([
            'name' => 'Sunday',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
