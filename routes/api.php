<?php

use App\Http\Controllers\Api\AiOffer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CategoryProductController;
use App\Http\Controllers\Api\TableController;

Route::get('get-offer', AiOffer::class)->middleware('auth');

Route::get('categories', CategoriesController::class);
Route::get('categories/{id}/products', CategoryProductController::class);
Route::get('table/{id}', [TableController::class, 'show']);