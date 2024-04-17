<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CheckoutController;
use App\Livewire\CourseList;
use App\Livewire\Pricing;
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


Route::get('/courses', CourseList::class)->name('courses');
Route::get('/courses/{course}', ShowCourse::class)->name('courses.show');

Route::get('/pricing', Pricing::class)->name('pricing');
Route::get('/billing', BillingController::class)->name('billing');

Route::get('/courses/{course}/episodes/{episode?}', WatchEpisode::class)
    ->middleware(['auth'])
    ->name('courses.episodes.show');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
