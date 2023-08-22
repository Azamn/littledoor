<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(MasterUserTypeSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(MasterEmotionsSeedeer::class);
        $this->call(MasterLanguagesSeeder::class);
        $this->call(MasterTimeSlotSeeder::class);


    }
}
