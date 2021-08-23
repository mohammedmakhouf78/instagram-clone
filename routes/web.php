<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/{any}', [WelcomeController::class, 'index'])->where('any', '.*');

