<?php

declare(strict_types=1);

namespace App\Http\Controllers\Components;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController
{
    public function index()
    {
        $restaurants = Restaurant::all();

        return response()->json(RestaurantResource::collection($restaurants), 200);
    }

    public function show($id)
    {
        $restaurant = Restaurant::query()
            ->with(['owner', 'products.categories']) // Load related models
            ->find($id);

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        return response()->json(new RestaurantResource($restaurant), 200);
    }

    public function random(Request $request)
    {
        $limit = $request->limit ?? 3;

        $restaurants = Restaurant::query()
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        return response()->json(RestaurantResource::collection($restaurants), 200);
    }
}
