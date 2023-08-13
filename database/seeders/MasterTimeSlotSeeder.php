<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterTimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('master_time_slots')->truncate();
        DB::table('master_time_slots')->insert([
            'slot_time' => '08:00 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '08:30 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '09:00 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '09:30 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '10:00 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '10:30 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '11:00 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '11:30 AM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '12:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '12:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '01:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '01:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '02:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '02:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '03:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '03:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '04:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '04:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '05:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '05:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '06:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '06:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '07:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '07:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '08:00 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('master_time_slots')->insert([
            'slot_time' => '08:30 PM',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
