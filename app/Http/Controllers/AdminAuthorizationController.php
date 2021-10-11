<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthorizationController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        if(config('admin.username') === $request->username && config('admin.password') === $request->password) {
            session()->put('admin_auth',[
                'role' => 'admin',
                'username' => config('admin.username')
            ]);

            return redirect()->route('admin.login');
        }

        return redirect()->route('admin.login')->withMessage("Incorrect username or password.");
    }

    public function logout()
    {
        session()->forget('admin_auth');

        return redirect()->route('admin.login');
    }
}
