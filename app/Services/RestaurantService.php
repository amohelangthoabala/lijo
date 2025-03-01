<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Services\Interfaces\RestaurantServiceInterface;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class RestaurantService implements RestaurantServiceInterface
{
    public function get(object $request): QueryBuilder
    {
        try {
            $query = QueryBuilder::for(Restaurant::class)
                ->with('owner')
                ->defaultSort('-created_at')
                ->allowedSorts(['name', 'address', 'phone', 'created_at'])
                ->allowedFilters(['name', 'address', 'phone']);

            return $query;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function store(RestaurantRequest $request): void
    {
        try {
            DB::transaction(function () use ($request) {
                Restaurant::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'owner_id' => $request->owner_id, // Ensure owner_id is provided
                ]);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant): void
    {
        try {
            DB::transaction(function () use ($request, $restaurant) {
                $restaurant->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'address' => $request->address,
                    'phone' => $request->phone,
                ]);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete(string $id): void
    {
        try {
            Restaurant::findOrFail($id)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteMultiple(array $ids): void
    {
        try {
            DB::transaction(function () use ($ids) {
                Restaurant::whereIn('id', $ids)->delete();
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function restore(string $id): void
    {
        try {
            Restaurant::onlyTrashed()->findOrFail($id)->restore();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function restoreMultiple(array $ids): void
    {
        try {
            DB::transaction(function () use ($ids) {
                Restaurant::onlyTrashed()->whereIn('id', $ids)->restore();
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
