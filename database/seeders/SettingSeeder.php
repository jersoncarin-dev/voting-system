<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'election_title' => 'PROSPERIDADNHS SSG VOTING 2021-2022',
            'election_message' => 'Election has not started yet!',
            'can_vote' => true,
            'assistance_message' => 'If you forgot your Learner Reference Number (LRN) contact Jerson Carin or Sean Blanco for assistance.'
        ]);
    }
}
