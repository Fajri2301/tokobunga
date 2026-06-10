<?php

use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', 'App\Http\Controllers\CatalogController@home')->name('home');

// Public Submissions with Rate Limiting (Anti-Spam)
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/reviews', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');
    Route::post('/checkout', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout');
});

// Cart Routes
Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::patch('/cart/update', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::delete('/cart/remove', 'App\Http\Controllers\CartController@remove')->name('cart.remove');

// Navigation Routes
Route::get('/katalog', 'App\Http\Controllers\CatalogController@index')->name('catalog.index');
Route::get('/produk/{slug}', 'App\Http\Controllers\CatalogController@show')->name('catalog.show');
Route::get('/tentang-kami', function() {
    $about = \App\Models\About::first();
    $reviews = \App\Models\Review::where('is_approved', true)->latest()->take(6)->get();
    $averageRating = \App\Models\Review::where('is_approved', true)->avg('rating') ?? 0;
    $totalReviews = \App\Models\Review::where('is_approved', true)->count();
    
    return view('pages.about', compact('about', 'reviews', 'averageRating', 'totalReviews'));
})->name('pages.about');
Route::get('/kontak', 'App\Http\Controllers\CatalogController@contact')->name('pages.contact');

// Chat Routes (Throttled)
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/chat/messages', 'App\Http\Controllers\ChatController@getMessages');
    Route::post('/chat/send', 'App\Http\Controllers\ChatController@sendMessage');
});

// Auth Routes
Route::get('/login', 'App\Http\Controllers\Admin\AuthController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Admin\AuthController@login')->name('login.post');
Route::post('/logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('logout');

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
    Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
    Route::resource('banners', 'App\Http\Controllers\Admin\BannerController');
    
    // Orders Management
    Route::get('orders', 'App\Http\Controllers\Admin\OrderController@index')->name('orders.index');
    Route::get('orders/{order}', 'App\Http\Controllers\Admin\OrderController@show')->name('orders.show');
    Route::patch('orders/{order}/status', 'App\Http\Controllers\Admin\OrderController@updateStatus')->name('orders.status');
    Route::delete('orders/{order}', 'App\Http\Controllers\Admin\OrderController@destroy')->name('orders.destroy');
    
    // Reviews Management
    Route::get('reviews', 'App\Http\Controllers\Admin\ReviewController@index')->name('reviews.index');
    Route::patch('reviews/{review}/approve', 'App\Http\Controllers\Admin\ReviewController@approve')->name('reviews.approve');
    Route::patch('reviews/{review}/unapprove', 'App\Http\Controllers\Admin\ReviewController@unapprove')->name('reviews.unapprove');
    Route::delete('reviews/{review}', 'App\Http\Controllers\Admin\ReviewController@destroy')->name('reviews.destroy');
    
    // Settings
    Route::get('settings', 'App\Http\Controllers\Admin\SettingController@edit')->name('settings.edit');
    Route::put('settings', 'App\Http\Controllers\Admin\SettingController@update')->name('settings.update');

    // Live Chat
    Route::get('chat', 'App\Http\Controllers\ChatController@index')->name('chat.index');
    Route::get('chat/{session_id}', 'App\Http\Controllers\ChatController@getSessionMessages')->name('chat.show');
    Route::post('chat/send', 'App\Http\Controllers\ChatController@adminSendMessage')->name('chat.send');
});

Route::get('/generate-password', function() {
    // Password diubah sesuai permintaan Anda menjadi 'admin123'
    return Illuminate\Support\Facades\Hash::make('admin123'); 
});
