<?php

use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [ProfesorController::class, 'dashboard'])->name('dashboard');
Route::get('asignaciones',[ProfesorController::class, 'asignaciones'])->name('asignaciones');