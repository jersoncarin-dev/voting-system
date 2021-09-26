<?php

use App\Http\Controllers\VoterController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('voter.guest')->group(function() {
    Route::get('/', [VoterController::class,'index'])->name('login');
    Route::post('/', [VoterController::class,'login']);    
});

Route::middleware('voter.auth')->group(function() {
    Route::get('logout', [VoterController::class,'logout'])->name('logout');
    Route::get('voting',[VotingController::class,'index'])->name('voting');
    Route::post('voting/submit',[VotingController::class,'submit'])->name('submit.ballot');
    Route::post('voting/preview',[VotingController::class,'preview'])->name('preview.ballot');
});

