<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Position;
use App\Models\Voter;

class AdminCandidatesController extends Controller
{
    public function index()
    {
        return view('admin.candidates',[
            'positions' => Position::all()
        ]);
    }

    public function list()
    {
        $candidates = Candidate::with(['position','voter']);

        $candidates = $candidates->get()->map(function($e) {
            return [
                'id' => $e->id,
                'name' => $e->voter->name,
                'position' => $e->position->name,
                'platform_content' => $e->platform_content ? 'Has Platform' : 'No Platform',
                'profile_link' => $e->profile_url,
                'grade_level' => $e->voter->grade_level
            ];
        });

        return datatables()->of($candidates)->make();
    }

    public function delete(Request $request)
    {
        if($candidate = Candidate::find($request->id)) {
            Vote::where('candidate_id',$candidate->id)->delete();
            $candidate->delete();

            return redirect()->route('admin.candidates.index')->withMessage("Successfully candidate deleted.");
        }

        return redirect()->route('admin.candidates.index')->withMessage("Failed to delete candidate.");
    }

    public function reset()
    {
        Candidate::truncate();
        Vote::truncate();

        return redirect()->back()->withMessage("Candidate resetted successfully"); 
    }

    public function voters(Request $request)
    {
        $voters = Voter::query()->when($request->q,function($q) use($request) {
          $q->where('name','like','%'.$request->q.'%');  
        })->paginate(10);

        return response()->json($voters);
    }

    public function add(Request $request)
    {
        Candidate::create($request->except(['_token']));

        return redirect()->back()->withMessage("Candidate created successfully");
    }

    public function edit(Request $request)
    {
        if($candidate = Candidate::find($request->id)) {
            $candidate->update($request->except(['_token','id']));
            return redirect()->back()->withMessage("Candidate updated successfully");
        }

        return redirect()->back()->withMessage("Failed to update candidate.");
    }

    public function show(Request $request)
    {
        if($candidate = Candidate::find($request->id)) {
            return response()->json($candidate);
        }

        return response()->json(['message' => '404 NOT FOUND'],404);
    }
}
