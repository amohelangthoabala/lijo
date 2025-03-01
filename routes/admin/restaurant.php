<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::prefix('restaurants')->group(function () {
    Route::controller(RestaurantController::class)->group(function () {
        // Delete
        Route::delete('/{restaurant}', 'destroy')->name('admin.restaurants.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.restaurants.destroy-multiple');

        // Restore
        Route::put('/{restaurant}/restore', 'restore')->name('admin.restaurants.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.restaurants.restore-multiple');

        // Index
        Route::get('/', 'index')->name('admin.restaurants.index');

        // Create
        Route::post('/', 'store')->name('admin.restaurants.store');

        // Update
        Route::put('/{restaurant}', 'update')->name('admin.restaurants.update');

        // Show single restaurant
        Route::get('/{restaurant}', 'show')->name('admin.restaurants.show');
    });
});
