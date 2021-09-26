<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Seeder;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Voter::insert([
            [
                'lrn' => '131775080080',
                'name' => 'Carin, Jerson A.',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080081',
                'name' => 'Dela Cruz, Katherine',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080082',
                'name' => 'Bahian, Ryan V.',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080083',
                'name' => 'Auxtero, Mel Rudge',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080084',
                'name' => 'Baynosa, Vanessa P.',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080085',
                'name' => 'Hoshino, Celio C.',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080086',
                'name' => 'Baynosa, Daryll P.',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ],
            [
                'lrn' => '131775080087',
                'name' => 'Udalbe, Adonis',
                'grade_level' => 12,
                'section' => 'MIJENO'
            ]
        ]);
    }
}
