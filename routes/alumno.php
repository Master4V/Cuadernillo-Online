<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AlumnoController::class, 'dashboard'])->name('dashboard');
Route::get('datos', [AlumnoController::class, 'datos'])->name('datos');
// Más rutas específicas para alumnos