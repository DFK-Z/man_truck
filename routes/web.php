<?php

use App\Http\Controllers\TruckController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Маршруты для грузовиков (публичная часть)
Route::get('/trucks', [TruckController::class, 'index'])->name('trucks.index');
Route::get('/trucks/create', [TruckController::class, 'create'])->name('trucks.create');
Route::post('/trucks', [TruckController::class, 'store'])->name('trucks.store');
Route::get('/trucks/{truck}', [TruckController::class, 'show'])->name('trucks.show');
Route::get('/trucks/{truck}/edit', [TruckController::class, 'edit'])->name('trucks.edit');
Route::put('/trucks/{truck}', [TruckController::class, 'update'])->name('trucks.update');
Route::delete('/trucks/{truck}', [TruckController::class, 'destroy'])->name('trucks.destroy');

// Админка Filament
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('filament.pages.dashboard');
    })->name('admin.dashboard');
});
