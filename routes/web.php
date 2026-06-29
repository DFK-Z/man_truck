<?php

use App\Http\Controllers\TruckController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TruckController::class, 'index']);
