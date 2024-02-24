<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Website routes
Route::group(['prefix' => 'websites'], function () {
    Route::get('/', [WebsiteController::class, 'index'])->name('websites.index'); // Get all websites
    Route::post('/', [WebsiteController::class, 'store'])->name('websites.store'); // Create a new website
    Route::get('/{website}', [WebsiteController::class, 'show'])->name('websites.show'); // Get a specific website
    Route::put('/{website}', [WebsiteController::class, 'update'])->name('websites.update'); // Update a specific website
    Route::delete('/{website}', [WebsiteController::class, 'destroy'])->name('websites.destroy'); // Delete a specific website

    // Subscription routes for a website
    Route::post('/{website}/subscribe', [SubscriptionController::class, 'subscribe'])->name('websites.subscribe'); // Subscribe to a website
    Route::delete('/{website}/unsubscribe/{email}', [SubscriptionController::class, 'unsubscribe'])->name('websites.unsubscribe'); // Unsubscribe from a website
    Route::get('/{website}/subscriptions', [SubscriptionController::class, 'getSubscriptions'])->name('websites.subscriptions'); // Get subscriptions for a website
});

// Post routes
Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index'); // Get all posts
    Route::post('/', [PostController::class, 'store'])->name('posts.store'); // Create a new post
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show'); // Get a specific post
    Route::put('/{post}', [PostController::class, 'update'])->name('posts.update'); // Update a specific post
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // Delete a specific post
});