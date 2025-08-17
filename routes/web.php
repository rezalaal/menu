<?php


use App\Livewire\CartPage;
use App\Livewire\Coral\Checkout;
use App\Livewire\OrderPage;
use App\Livewire\OrderView;
use App\Livewire\ProductView;
use App\Livewire\ProductsPage;
use App\Livewire\ProfilePage;
use App\Livewire\SearchPage;
use App\Livewire\WaiterPage;
use Illuminate\Support\Facades\Route;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

// Routes
Route::get('/table/{id}', \App\Livewire\Table::class);
Route::get('/', \App\Livewire\Coral\PwaPage::class)->name('home');
Route::get('/categories', \App\Livewire\CategoryPage::class);
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


