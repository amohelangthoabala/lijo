<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->group(function () {
    Route::controller(RestaurantController::class)->group(function () {
        // List all restaurants
        Route::get('/', 'index')->name('restaurants.index');

        // Show a single restaurant by slug
        Route::get('/{slug}', 'show')->name('restaurants.show');
    });
});
