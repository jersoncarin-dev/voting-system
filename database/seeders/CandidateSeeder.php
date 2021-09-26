<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Candidate::insert([
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 1,
                'voter_id' => 2
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 1,
                'voter_id' => 3
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 1,
                'voter_id' => 4
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 2,
                'voter_id' => 5
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 2,
                'voter_id' => 6
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 3,
                'voter_id' => 7
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 3,
                'voter_id' => 8
            ],
            [
                'platform_content' => 'Hello world!',
                'profile_url' => 'https://via.placeholder.com/500',
                'position_id' => 3,
                'voter_id' => 1
            ]
        ]);
    }
}
