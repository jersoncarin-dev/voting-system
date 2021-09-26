<?php

namespace Database\Seeders;

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
        $this->call(VoterSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
