<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings',[
            'setting' => Setting::find(1)
        ]);
    }

    public function update(Request $request)
    {
        $can_vote = $request->can_vote ? 1 : 0;

        Setting::find(1)->update([
            'can_vote' => $can_vote,
            'election_title' => $request->election_title,
            'election_message' => $request->election_message,
            'assistance_message' => $request->assistance_message
        ]);

        return redirect()->back()->withMessage("Settings updated successfully");
    }
}
