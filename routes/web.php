<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;

use App\Http\Controllers\RaceController;
use App\Http\Controllers\RaceCheckpointController;

use App\Http\Controllers\RaceLogController;

use App\Http\Controllers\RaceReportController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['web'])->group(function() {
    Route::resource('teams', TeamController::class);
    Route::resource('members', TeamMemberController::class);
});

Route::resource('races', RaceController::class);
Route::post('races/{race}/checkpoints', [RaceCheckpointController::class, 'store'])->name('checkpoints.store');
Route::delete('races/{race}/checkpoints/{checkpoint}', [RaceCheckpointController::class, 'destroy'])->name('checkpoints.destroy');

Route::resource('race_logs', RaceLogController::class)->only(['index', 'create', 'store']);

Route::get('/race-reports', [RaceReportController::class, 'index'])->name('race.reports');
    