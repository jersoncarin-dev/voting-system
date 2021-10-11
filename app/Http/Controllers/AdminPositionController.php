<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Vote;
use App\Models\Candidate;

class AdminPositionController extends Controller
{
    public function index()
    {
        return view('admin.positions');
    }

    public function list()
    {
        $voters = Position::select('id','name','max_vote',\DB::raw('IF(relation_level = 0,"NO","YES") as relation'));

        return datatables()->of($voters)->make();
    }

    public function delete(Request $request)
    {
        if($position = Position::find($request->id)) {
            Vote::where('position_id',$position->id)->delete();
            Candidate::where('position_id',$position->id)->delete();

            $position->delete();

            return redirect()->route('admin.positions.index')->withMessage("Successfully position deleted.");
        }

        return redirect()->route('admin.positions.index')->withMessage("Failed to delete position.");
    }

    public function reset()
    {
        Candidate::truncate();
        Vote::truncate();
        Position::truncate();

        return redirect()->back()->withMessage("Position resetted successfully"); 
    }

    public function show(Request $request)
    {
        if($position = Position::find($request->id)) {
            return response()->json($position);
        }

        return response()->json(['message' => '404 NOT FOUND'],404);
    }

    public function add(Request $request)
    {
        $relation_level = $request->relation_level ? 1 : 0;

        Position::create([
            'name' => $request->name,
            'max_vote' => $request->max_vote,
            'relation_level' => $relation_level
        ]);

        return redirect()->back()->withMessage("Position added successfully"); 
    }

    public function edit(Request $request)
    {
        $relation_level = $request->relation_level ? 1 : 0;

        if($position = Position::find($request->id)) {
            $position->update(array_merge($request->except(['_token','id']),['relation_level' => $relation_level]));

            return redirect()->back()->withMessage("Position updated successfully");
        }

        return redirect()->back()->withMessage("Failed to update position.");
    }
}
