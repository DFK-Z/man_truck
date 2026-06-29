<?php

use App\Http\Controllers\TruckController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TruckController::class, 'index'])->name('home');
Route::get('/truck/{id}', [TruckController::class, 'show'])->name('truck.detail');
