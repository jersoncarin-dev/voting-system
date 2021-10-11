<?php

use App\Http\Controllers\AdminAuthorizationController;
use App\Http\Controllers\AdminCandidatesController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminVoteController;
use App\Http\Controllers\AdminVotersController;
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

    Route::prefix('voting')->group(function() {
        Route::get('/',[VotingController::class,'index'])->name('voting');
        Route::post('submit',[VotingController::class,'submit'])->name('submit.ballot');
        Route::post('preview',[VotingController::class,'preview'])->name('preview.ballot');
    });
});

Route::group(['prefix' => 'admin','as' => 'admin.'],function() {
    Route::middleware('admin.guest')->group(function() {
        Route::get('/',[AdminAuthorizationController::class,'index'])->name('login');
        Route::post('/',[AdminAuthorizationController::class,'login']);
    });

    Route::middleware('admin.auth')->group(function() {
        Route::get('logout',[AdminAuthorizationController::class,'logout'])->name('logout');
        Route::get('home',[AdminHomeController::class,'index'])->name('home');

        Route::prefix('voters')->name('voters.')->group(function() {
            Route::get('/',[AdminVotersController::class,'index'])->name('index');
            Route::get('list',[AdminVotersController::class,'list'])->name('list');
            Route::get('show/{id?}',[AdminVotersController::class,'show'])->name('show');
            Route::post('edit',[AdminVotersController::class,'edit'])->name('edit');
            Route::post('add',[AdminVotersController::class,'add'])->name('add');
            Route::post('import',[AdminVotersController::class,'import'])->name('csv');
            Route::post('reset',[AdminVotersController::class,'reset'])->name('reset');
            Route::get('delete/{id?}',[AdminVotersController::class,'delete'])
                ->name('delete')
                ->middleware('query.token');
        });

        Route::prefix('candidates')->name('candidates.')->group(function() {
            Route::get('/',[AdminCandidatesController::class,'index'])->name('index');
            Route::get('list',[AdminCandidatesController::class,'list'])->name('list');
            Route::post('reset',[AdminCandidatesController::class,'reset'])->name('reset');
            Route::get('voters',[AdminCandidatesController::class,'voters'])->name('voters');
            Route::post('add',[AdminCandidatesController::class,'add'])->name('add');
            Route::post('edit',[AdminCandidatesController::class,'edit'])->name('edit');
            Route::get('show',[AdminCandidatesController::class,'show'])->name('show');
            Route::get('delete/{id?}',[AdminCandidatesController::class,'delete'])
                ->name('delete')
                ->middleware('query.token');
        });

        Route::prefix('positions')->name('positions.')->group(function() {
            Route::get('/',[AdminPositionController::class,'index'])->name('index');
            Route::get('list',[AdminPositionController::class,'list'])->name('list');
            Route::post('reset',[AdminPositionController::class,'reset'])->name('reset');
            Route::post('add',[AdminPositionController::class,'add'])->name('add');
            Route::post('edit',[AdminPositionController::class,'edit'])->name('edit');
            Route::get('show',[AdminPositionController::class,'show'])->name('show');
            Route::get('delete/{id?}',[AdminPositionController::class,'delete'])
                ->name('delete')
                ->middleware('query.token');
        });

        Route::prefix('votes')->name('votes.')->group(function() {
            Route::get('/',[AdminVoteController::class,'index'])->name('index');
            Route::get('list',[AdminVoteController::class,'list'])->name('list');
            Route::post('reset',[AdminVoteController::class,'reset'])->name('reset');
            Route::post('print',[AdminVoteController::class,'print'])->name('print');
        });

        Route::prefix('settings')->name('settings.')->group(function() {
            Route::get('/',[AdminSettingsController::class,'index'])->name('index');
            Route::post('update',[AdminSettingsController::class,'update'])->name('update');
        });
    });
});

