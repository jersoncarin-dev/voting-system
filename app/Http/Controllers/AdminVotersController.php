<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Voter;
use App\Models\Vote;
use Illuminate\Http\Request;
use Validator;

class AdminVotersController extends Controller
{
    public function index()
    {
        return view('admin.voters');
    }

    public function list()
    {
        $voters = Voter::select('id','lrn','name','grade_level','section');

        return datatables()->of($voters)->make();
    }

    public function show(Request $request)
    {
        if($voter = Voter::find($request->id)) {
            return response()->json($voter);
        }

        return response()->json(['message' => '404 NOT FOUND'],404);
    }

    public function edit(Request $request)
    {
        if($voter = Voter::find($request->id)) {
            $voter->update($request->except(['_token','id']));

            return redirect()->back()->withMessage("Voter updated successfully");
        }

        return redirect()->back()->withMessage("Voter failed to update");
    }

    public function add(Request $request)
    {
        $voter = $request->except(['_token']);

        Voter::insert($voter);

        return redirect()->back()->withMessage("Voter created successfully");
    }

    public function import(Request $request)
    {
        $rules = ['csv' => 'required|mimes:csv'];

        $messages = [
            'csv.required' => 'CSV is required.',
            'csv.mimes' => 'Only .csv format accepted'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()) {
            return redirect()->back()->withMessage($validator->errors()->first());
        }

        $csv = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $request->file('csv')->get()));

        // Remove the heading
        array_shift($csv);

        // Replace index value with associative keys
        $csv = array_map(function($csv) {
            return [
                'lrn' => array_shift($csv),
                'name' => array_shift($csv),
                'section' => array_shift($csv),
                'grade_level' => array_shift($csv)
            ];
        },$csv);

        // Remove null values or empty values
        $csv = array_filter($csv,function($e) {
            return !is_null($e['lrn']) &&
                !is_null($e['name']) &&
                !is_null($e['section']) &&
                !is_null($e['grade_level']); 
        });

        // Insert into database
        Voter::insert($csv);

        return redirect()->back()->withMessage("CSV is imported successfully");
    }

    public function reset()
    {
        Voter::truncate();
        Candidate::truncate();
        Vote::truncate();

        return redirect()->back()->withMessage("Voters resetted successfully"); 
    }

    public function delete(Request $request)
    {
        $voter = Voter::find($request->id);

        if(!$voter) {
            return redirect()->route('admin.voters.index')->withMessage('Failed to delete voter.');
        }

        if($candidate = Candidate::where('voter_id',$request->id)->first()) {
            Vote::where('candidate_id',$candidate->id)->delete();
            Candidate::find($candidate->id)->delete();
        }
 
        Vote::where('voter_id',$request->id)->delete();

        $voter->delete();

        return redirect()->route('admin.voters.index')->withMessage("Successfully voter deleted.");
    }
}
