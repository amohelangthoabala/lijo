<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Services\FlashNotification;
use App\Services\RestaurantService;
use Gate;
use Illuminate\Http\Request;

class RestaurantController
{
    public function index(Request $request)
    {
        abort_unless(Gate::allows('restaurant-list'), 404);

        // Set query
        $query = (new RestaurantService())->get($request);

        // Set pagination
        $restaurants = $query->paginate($request->rows ?? config('jie.per_page'))->appends($request->all());

        // Set resource
        $query = RestaurantResource::collection($restaurants);

        return inertia('Admin/Restaurants/Index', [
            'restaurants' => $query,
        ]);
    }

    public function store(RestaurantRequest $request)
    {
        Gate::authorize('restaurant-create');

        (new RestaurantService())->store($request);

        (new FlashNotification())->create($request->name);

        return redirect()->back();
    }

    public function show(Restaurant $restaurant)
    {
        return response()->json(new RestaurantResource($restaurant));
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        Gate::authorize('restaurant-update');

        (new RestaurantService())->update($request, $restaurant);

        (new FlashNotification())->update($request->name);

        return redirect()->back();
    }

    public function destroy(Restaurant $restaurant)
    {
        Gate::authorize('restaurant-delete');

        (new RestaurantService())->delete($restaurant->id);

        (new FlashNotification())->destroy($restaurant->name, [
            [
                'url' => route('admin.restaurants.restore', $restaurant->id),
                'method' => 'put',
            ],
        ]);

        return redirect()->back();
    }

    public function destroyMultiple(Request $request)
    {
        Gate::authorize('restaurant-delete');

        (new RestaurantService())->deleteMultiple($request->ids);

        (new FlashNotification())->destroy(count($request->ids) . ' restaurants', [
            [
                'url' => route('admin.restaurants.restore-multiple'),
                'method' => 'put',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }

    public function restore(Restaurant $restaurant)
    {
        Gate::authorize('restaurant-delete');

        (new RestaurantService())->restore($restaurant->id);

        (new FlashNotification())->restore($restaurant->name, [
            [
                'url' => route('admin.restaurants.destroy', $restaurant->id),
                'method' => 'delete',
            ],
        ]);

        return redirect()->back();
    }

    public function restoreMultiple(Request $request)
    {
        Gate::authorize('restaurant-delete');

        (new RestaurantService())->restoreMultiple($request->ids);

        (new FlashNotification())->restore(count($request->ids) . ' restaurants', [
            [
                'url' => route('admin.restaurants.destroy-multiple'),
                'method' => 'delete',
                'data' => [
                    'ids' => $request->ids,
                ],
            ],
        ]);

        return redirect()->back();
    }
}
