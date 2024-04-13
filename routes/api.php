<?php

use App\Http\Controllers\QuotesController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiTokenAuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/user', [UserController::class, 'store'])->name('create-user');
Route::get('/quotes', [QuotesController::class, 'index'])->name('get-quotes')->middleware(ApiTokenAuthMiddleware::class);
