<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/home', static function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes([]);
Route::get('password/change', function () {
    return view('auth.change-password');
})->name('auth.password.change');

Route::group([
    'prefix'     => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['auth', 'first_login']
], static function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', Controllers\Admin\PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy',
        'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media',
        'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia',
        'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');


//    Route::group([
//        'prefix'     => 'orders',
//        'as'         => 'orders.',
//        'middleware' => ['auth'],
//    ], static function () {
//        // Change password
//        Route::get('/', [OrderController::class, 'index'])->name('index');
//        Route::get('/create', [OrderController::class, 'index'])->name('create');
//        Route::post('/create', [OrderController::class, 'index'])->name('store');
//        Route::get('/create', 'ChangePasswordController@update')->name('password.update');
//        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
//        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
//    });
});


Route::group([
    'prefix'     => 'profile',
    'as'         => 'profile.',
    'middleware' => ['auth'],
], static function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [Controllers\Auth\ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile',
            [Controllers\Auth\ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy',
            [Controllers\Auth\ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
    }
});

Route::resource('orders', Controllers\OrderController::class)->middleware(['auth', 'first_login']);

Route::group([
    'prefix'     => 'carts',
    'as'         => 'carts.',
    'middleware' => ['auth', 'first_login'],
], static function () {
    Route::get('/', [Controllers\CartController::class, 'index'])->name('index');
    Route::post('/{product}', [Controllers\CartController::class, 'store'])->name('store');
    Route::delete('/{product}', [Controllers\CartController::class, 'destroy'])->name('destroy');
});

