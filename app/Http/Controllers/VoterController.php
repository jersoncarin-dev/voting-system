<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Voter;
use Illuminate\Http\Request;
use Auth;

class VoterController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('login',compact('setting'));
    }

    /**
     * Attempt to login using Learning Reference Number
     */
    public function login(Request $request)
    {
        $voter = Voter::where('lrn',$request->post('lrn'))->first();

        $setting = Setting::first();

        if(!$setting->can_vote) {
            return redirect('/')->withMessage($setting->election_message);
        } 

        if(!$voter) {
            return redirect('/')->withMessage('Invalid Learner Reference Number.');
        }

        // Determine when the voter is being blocked
        if($voter->is_blocked) {
            return redirect('/')->withMessage('Learner Reference Number has been blocked.');
        }
        
        Auth::login($voter);

        return redirect()->route('voting');
    }

    /**
     * Attempt to logout
     */
    public function logout() 
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
