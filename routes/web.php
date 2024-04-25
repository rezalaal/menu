<?php

use App\Livewire\CartPage;
use App\Livewire\OrderPage;
use App\Livewire\OrderView;
use App\Livewire\ProductView;
use App\Livewire\ProductsPage;
use App\Livewire\ProfilePage;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;


Route::get('/table/{id}', \App\Livewire\Table::class);
Route::get('/', \App\Livewire\CategoryPage::class);
Route::get('/products/{category}', ProductsPage::class);
Route::get('/product/{product}', ProductView::class);
Route::get('/cart', CartPage::class);
Route::get('/orders', OrderPage::class);
Route::get('/orders/{order}', OrderView::class);
Route::get('/search', SearchPage::class);
Route::get('/profile', ProfilePage::class);
