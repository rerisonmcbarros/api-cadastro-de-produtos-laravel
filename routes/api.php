<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::apiResource('categorias', CategoryController::class)->names([
    'index' => 'categories.index',
    'store' => 'categories.store',
    'show' => 'categories.show',
    'update' => 'categories.update',
    'destroy' => 'categories.destroy'
])->parameters([
    'categorias' => 'id'
]);

Route::post('produtos/{id}/adicionar-foto', [ProductController::class, 'addImage']);
Route::delete('produtos/remover-foto/{idImage}', [ProductController::class, 'removeImage']);

Route::apiResource('produtos', ProductController::class)->names([
    'index' => 'products.index',
    'store' => 'products.store',
    'show' => 'products.show',
    'update' => 'products.update',
    'destroy' => 'products.destroy'
])->parameters([
    'produtos' => 'id'
]);
