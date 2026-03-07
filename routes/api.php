<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Cross Tanzania API is running']);
});

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

Route::get('/blog/posts', [BlogController::class, 'posts']);
Route::get('/blog/posts/{slug}', [BlogController::class, 'post']);
Route::get('/blog/posts/{slug}/comments', [BlogController::class, 'comments']);
Route::get('/blog/categories', [BlogController::class, 'categories']);
Route::get('/blog/sub-categories', [BlogController::class, 'subCategories']);

Route::get('/gallery/categories', [GalleryController::class, 'categories']);
Route::get('/gallery/images', [GalleryController::class, 'images']);

Route::post('/contact', [ContactController::class, 'store']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/send-otp', [VerificationController::class, 'sendOtp']);
    Route::post('/verify-otp', [VerificationController::class, 'verifyOtp']);
    Route::get('/my-events', [EventController::class, 'myEvents']);
    Route::post('/events/{event}/register', [EventController::class, 'register']);

    Route::post('/blog/posts/{slug}/comments', [BlogController::class, 'storeComment']);
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    
    Route::post('/payments/initiate', [PaymentController::class, 'initiate']);
    Route::get('/payments/{id}/status', [PaymentController::class, 'status']);
    Route::post('/snippe/webhook', [PaymentController::class, 'webhook'])->name('snippe.webhook');

    Route::get('/user', function (Request $request) {
        return $request->user()->load('participant');
    });
});
