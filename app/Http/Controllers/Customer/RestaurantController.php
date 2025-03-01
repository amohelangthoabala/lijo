<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::query()
            ->with('owner') // Load owner details if needed
            ->when($request->search, fn ($query) => $query->where('name', 'like', "%{$request->search}%"))
            ->paginate($request->rows ?? 12);

        return Inertia::render('Customer/Restaurants/Index', [
            'restaurants' => RestaurantResource::collection($restaurants),
        ]);
    }

    public function show(string $id)
    {
        $restaurant = Restaurant::query()
            ->with(['owner', 'products.categories']) // Load related products and categories
            ->findOrFail($id);

        return Inertia::render('Customer/Restaurants/Show', [
            'restaurant' => new RestaurantResource($restaurant),
        ]);
    }
}
