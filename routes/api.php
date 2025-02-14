<?php

use App\Http\Controllers\SearchPostController;
use Illuminate\Support\Facades\Route;


Route::prefix('post')
    ->group(function () {
        Route::controller(\App\Http\Controllers\PostController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::get('/show/{id}', 'show');
            Route::post('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'destroy');
            Route::post('/search', 'search');
        });

        Route::post('/search', SearchPostController::class);
    });
