<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Position;
use App\Models\Vote;
use App\Models\Voter;

class AdminHomeController extends Controller
{
    public function index()
    {
        $voter = Position::with([
            'candidates' => fn($q) => $q->withCount('votes'),
            'candidates.voter'
        ])->get();

        return view('admin.home',[
            'voters' => Voter::count(),
            'candidates' => Candidate::count(),
            'positions' => Position::count(),
            'votes' => Vote::query()
                ->from(\DB::raw('(select count(distinct(voter_id)) as vote_count from votes group by voter_id) as t'))
                ->sum(\DB::raw('t.vote_count')),
            'positions_data' => $voter,
        ]);
    }
}
