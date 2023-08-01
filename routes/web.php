<?php

use App\Http\Livewire\Settings;
use App\Models\JobPost;
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

Route::get('/menubar/', function () {
    $jobs = JobPost::whereNull('deleted_at')->orderBy('published_at', 'desc')->limit(10)->get()->all();

    return view('menubar.index', ['jobPosts' => $jobs]);
})->name('menubar.index');

Route::get('/settings', Settings::class)->name('menubar.settings');