<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Setting;
use App\Models\Vote;
use Illuminate\Http\Request;
use Auth;

class VotingController extends Controller
{
    /**
     * Show the voting ui
     */
    public function index()
    {
        $positions = Position::with('candidates','candidates.voter')->get();
        $vote = Vote::where('voter_id',Auth::id())->get();
        $setting = Setting::first();

        return view('voting',compact('positions','vote','setting'));
    }

    /**
     * Attempt to submit the ballot
     */
    public function submit(Request $request)
    {
        $ballots = $request->except('_token');

        $vote = Vote::where('voter_id',Auth::id())->first();

        if($vote) {
            return redirect()->back();
        }

        if(!$ballots) {
            return redirect()->back()->withMessage('You may select atleast 2 or more candidates.');
        }

        $votes = $this->parseBallot($ballots);

        // Finally insert into votes db
        Vote::insert($votes);

        return redirect()->route('voting')->withMessage('Your vote has been submitted.');
    }

    /**
     * Parse the ballots
     */
    protected function parseBallot(array $ballots): array
    {
        $votes = [];

        foreach($ballots as $pos => $ballot) {
            $pos = str_replace('position_','',$pos);

            if(is_array($ballot)) {
                foreach($ballot as $checkBallot) {
                    $votes[] = [
                        'position_id' => (int) $pos,
                        'voter_id' => Auth::id(),
                        'candidate_id' => (int) $checkBallot
                    ];
                }
            } else {
                $votes[] = [
                    'position_id' => (int) $pos,
                    'voter_id' => Auth::id(),
                    'candidate_id' => (int) $ballot
                ];
            }
        }

        return $votes;
    }

    /**
     * Preview Ballots
     */
    public function preview(Request $request)
    {
        $ballots = $request->except('_token');

        $vote = Vote::where('voter_id',Auth::id())->first();

        if($vote) {
            return redirect()->back();
        }

        if(!$ballots) {
            return response()->json([
                'error' => true,
                'message' => '<div class="alert alert-danger" role="alert">You may select atleast 2 or more candidates.</div>'
            ]);
        }

        $positions = Position::with('candidates','candidates.voter')->get();
        $vote = collect($this->parseBallot($ballots));

        return response()->json([
            'error' => false,
            'message' => view('preview',compact('positions','vote'))->render()
        ]);
    }
}
