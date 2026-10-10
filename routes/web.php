<?php

use App\Exports\ProductsExport;
use App\Livewire\CartPage;
use App\Livewire\CategoryPage;
use App\Livewire\Coral\Checkout;
use App\Livewire\Coral\PwaPage;
use App\Livewire\OrderPage;
use App\Livewire\OrderView;
use App\Livewire\ProductsPage;
use App\Livewire\ProductView;
use App\Livewire\ProfilePage;
use App\Livewire\SearchPage;
use App\Livewire\Table;
use App\Livewire\WaiterPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

// Routes
Route::get('/table/{id}', Table::class);
Route::get('/', PwaPage::class)->name('home');
Route::get('/categories', CategoryPage::class);
Route::get('/products/{category}', ProductsPage::class);
Route::get('/product/{product}', ProductView::class);
Route::get('/cart', CartPage::class)->middleware('auth');
Route::get('/orders', OrderPage::class)->middleware('auth');
// Route::get('/orders/{order}', OrderView::class);
// Route::get('/search', SearchPage::class);
Route::get('/profile', ProfilePage::class)->middleware('auth');
Route::get('/waiter', WaiterPage::class);
Route::get('/checkout', Checkout::class)->middleware('auth');
Route::get('/login', function () {
    return redirect('/table/1');
})->name('login');

Route::get('/admin/products/export-excel', function () {
    return Excel::download(new ProductsExport, 'products.xlsx');
})->middleware(['web', 'auth'])->name('filament.products.export');

Route::get('/clear-category-cache', function () {
    Cache::forget('products_by_category_v2');
    Cache::forget('categories_v2');

    return 'Category product caches cleared!';
});
