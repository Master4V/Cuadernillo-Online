<?php

use App\Http\Controllers\ProfeController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [ProfeController::class, 'dashboard'])->name('dashboard');
