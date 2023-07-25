<?php

use App\Http\Controllers\FetchJobs;
use Illuminate\Support\Facades\Route;

Route::get('/', FetchJobs::class);