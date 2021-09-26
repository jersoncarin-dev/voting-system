<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            [
                'name' => 'President',
                'max_vote' => 1,
                'relation_level' => 0
            ],
            [
                'name' => 'Vice President',
                'max_vote' => 1,
                'relation_level' => 0
            ],
            [
                'name' => 'Representative',
                'max_vote' => 3,
                'relation_level' => 1
            ]
        ]);
    }
}
