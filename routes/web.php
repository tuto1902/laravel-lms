<?php

use App\Livewire\ShowCourse;
use App\Livewire\WatchEpisode;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/courses/{course}', ShowCourse::class)->name('courses.show');
Route::get('/courses/{course}/episodes/{episode?}', WatchEpisode::class)->name('courses.episodes.show');
