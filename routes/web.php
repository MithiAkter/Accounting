<?php
  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
   
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
    Route::get('/delete/product/{id}', [ProductController::class, 'DeleteProduct'])->name('product.destroy');;
    Route::get('/view/product/{id}', [ProductController::class, 'ViewProduct'])->name('product.view');;



    Route::get('/inactive/product/{id}', [ProductController::class, 'Inactive'])->name('inactive.product');;
    Route::get('/active/product/{id}', [ProductController::class, 'Active'])->name('active.product');;

});