<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicArchiveController;

Route::get('/', [PublicArchiveController::class, 'index'])
    ->name('public.home');

Route::get('/arsip/{archive}', [PublicArchiveController::class, 'show'])
    ->name('public.show');

Route::get('/arsip/{archive}/download',
    [PublicArchiveController::class, 'download']
)->name('public.download');

Route::post('/arsip/verify-token', [PublicArchiveController::class, 'verifyToken'])
    ->name('public.verifyToken');
