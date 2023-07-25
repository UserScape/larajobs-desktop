<?php

use App\Http\Controllers\FeedsController;
use App\Http\Controllers\WatchingController;
use App\Utility\RssFeedLoader;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [FeedsController::class, 'index']);
Route::get('watching', [WatchingController::class, 'index']);
Route::post('watching', [WatchingController::class, 'update']);
