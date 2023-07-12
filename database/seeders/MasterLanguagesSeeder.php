<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_languages')->truncate();
        DB::table('master_languages')->insert([
            'name' => 'English',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_languages')->insert([
            'name' => 'Hindi',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_languages')->insert([
            'name' => 'Marathi',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
