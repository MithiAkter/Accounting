<?php
  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BuyProductController;
use App\Http\Controllers\PaymentShowController;

Route::get('/', function () {
    return view('auth.login');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');

  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);


    //products
    Route::get('/admin/product/all', [ProductController::class, 'index'])->name('all.product');
    Route::get('/admin/product/add', [ProductController::class, 'create'])->name('product.add');
    Route::post('/admin/store/product', [ProductController::class, 'store'])->name('store.product');
    Route::get('/edit/product/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');
    Route::post('/update/product/{id}', [ProductController::class, 'UpdateProduct'])->name('product.update');
    Route::get('/delete/product/{id}', [ProductController::class, 'DeleteProduct'])->name('product.destroy');
    Route::get('/view/product/{id}', [ProductController::class, 'ViewProduct'])->name('products.show');
    //Customer Section
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
    Route::put('/customer-update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/customer-delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    //Buy Product
    Route::get('/buyproduct', [BuyProductController::class, 'index'])->name('buyproduct');
    Route::get('/buy-product/{id}', [BuyProductController::class, 'buyProduct'])->name('buy.product');
    Route::post('/admin/store/buyproduct', [BuyProductController::class, 'store'])->name('store.buyproduct');

    //Customer Section
    // Route::get('/payment', [BuyProductController::class, 'paymentIndex'])->name('payment');
    
    Route::get('/payment', [BuyProductController::class, 'paymentIndex'])->name('payment.index');
    Route::post('/payment/process', [BuyProductController::class, 'processPayment'])->name('process.payment');
    Route::get('/get-due-payment', [BuyProductController::class, 'getDuePayment'])->name('get.due.payment');
    Route::post('/process-payment', [BuyProductController::class, 'processPayment'])->name('process.payment');


    Route::get('/payments/{customerId}/{productId}', [PaymentShowController::class, 'showPaymentDetails'])->name('payment.show');

    
});