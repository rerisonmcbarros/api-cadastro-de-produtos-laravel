<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categorias', CategoryController::class)->names([
    'index' => 'categories.index',
    'store' => 'categories.store',
    'show' => 'categories.show',
    'update' => 'categories.update',
    'destroy' => 'categories.destroy'
])->parameters([
    'categorias' => 'id'
]);
