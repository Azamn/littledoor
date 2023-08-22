<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterEmotionsSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_emotions')->truncate();
        DB::table('master_emotions')->insert([
            'name' => 'Happy',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_emotions')->insert([
            'name' => 'Angry',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_emotions')->insert([
            'name' => 'Sad',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_emotions')->insert([
            'name' => 'Manic',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_emotions')->insert([
            'name' => 'Calm',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
