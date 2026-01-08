<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeakCheckController;

Route::get('/', function () {
    return view('home');
});

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::get('/ebooks', [App\Http\Controllers\EbookController::class, 'index'])->name('ebooks.index');
Route::get('/ebooks/{slug}', [App\Http\Controllers\EbookController::class, 'show'])->name('ebooks.show');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/layanan', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// API Routes for Homepage
Route::prefix('api/home')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\HomeController::class, 'index']);
    Route::get('/hero', [App\Http\Controllers\Api\HomeController::class, 'hero']);
    Route::get('/partners', [App\Http\Controllers\Api\HomeController::class, 'partners']);
    Route::get('/sections', [App\Http\Controllers\Api\HomeController::class, 'sections']);
    Route::get('/section/{key}', [App\Http\Controllers\Api\HomeController::class, 'section']);
    Route::get('/ebooks', [App\Http\Controllers\Api\HomeController::class, 'ebooks']);
});

// Blog API Routes
Route::prefix('api/blog')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\BlogController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\BlogController::class, 'categories']);
    Route::get('/recent', [App\Http\Controllers\Api\BlogController::class, 'recent']);
    Route::get('/{slug}', [App\Http\Controllers\Api\BlogController::class, 'show']);
});

Route::get('api/page/{key}', [App\Http\Controllers\Api\PageController::class, 'show']);

// Ebook API Routes
Route::prefix('api/ebooks')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\EbookController::class, 'index']);
    Route::get('/topics', [App\Http\Controllers\Api\EbookController::class, 'topics']);
    Route::get('/{slug}', [App\Http\Controllers\Api\EbookController::class, 'show']);
});

// Product API Routes
Route::prefix('api/products')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/domains', [App\Http\Controllers\Api\ProductController::class, 'domains']);
    Route::get('/types', [App\Http\Controllers\Api\ProductController::class, 'types']);
    Route::get('/{slug}', [App\Http\Controllers\Api\ProductController::class, 'show']);
});

// Service API Routes
Route::prefix('api/services')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ServiceController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\ServiceController::class, 'categories']);
    Route::get('/{slug}', [App\Http\Controllers\Api\ServiceController::class, 'show']);
});


// Authentication Routes
Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('auth.verify-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Leak Check routes
    Route::get('/leak-check', [LeakCheckController::class, 'index'])->name('leak-check.index');
    
    // Rate Limit: 5 per minute (Prevents API abuse & DDoS)
    Route::post('/leak-check', [LeakCheckController::class, 'check'])->middleware('throttle:5,1')->name('leak-check.check');
    
    // Rate Limit: 3 per minute (Prevents spamming request forms)
    Route::post('/leak-check/request', [LeakCheckController::class, 'requestData'])->middleware('throttle:3,1')->name('leak-check.request');
    
    // Rate Limit: 20 per minute (Prevents log flooding)
    Route::get('/leak-check/logs', [LeakCheckController::class, 'getLogs'])->middleware('throttle:20,1')->name('leak-check.logs');
});
