<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ALUMNO RUTAS:
Route::middleware(['auth', 'role:alumno'])->prefix('alumno')->name('alumno.')->group(function () {
    Route::get('/dashboard', function () {
        return view('alumno.dashboard');
    })->name('dashboard');
    
    Route::get('/datos', [AlumnoController::class, 'datos'])->name('datos'); // Mejor usando controlador
});

//PROFESOR RUTAS:
Route::middleware(['auth', 'role:profesor'])->prefix('profesor')->name('profesor.')->group(function () {
    Route::get('/dashboard', function(){
        return view('profesor.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
