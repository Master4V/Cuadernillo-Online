<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AlumnoController::class, 'dashboard'])->name('dashboard');
// Más rutas específicas para alumnos