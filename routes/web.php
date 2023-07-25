<?php

use App\Livewire\JobItemResources\Pages\ListJobItems;
use App\Livewire\MyStatsPage;
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

// Route::view('/', 'welcome');
Route::get('/', ListJobItems::class);
Route::get('stats', MyStatsPage::class);
