<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Ресурсные маршруты для грузовиков
Route::resource('trucks', TruckController::class);

// Filament админка (автоматически)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// ВСЁ! Никаких лишних маршрутов для админки
