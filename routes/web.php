<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Pantalla principal: "Mis sitios favoritos"
Route::get('/', [SiteController::class, 'index'])->name('sites.index');
Route::post('/sitios', [SiteController::class, 'store'])->name('sites.store');
Route::delete('/sitios/{site}', [SiteController::class, 'destroy'])->name('sites.destroy');

// Pantalla "Mis categorías"
Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
