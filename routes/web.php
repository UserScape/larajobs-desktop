<?php

use Illuminate\Support\Facades\Route;
use App\Events\ClickedJob;
use App\Models\Larajob;
use Native\Laravel\Client\Client;
use Native\Laravel\Notification;
use Illuminate\Support\Facades\Log;

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

Route::get('/', function () {
    $jobs = Larajob::latest()->get();

    return view('jobs')->with(compact('jobs'));
});
