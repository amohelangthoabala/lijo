<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use Spatie\QueryBuilder\QueryBuilder;

interface RestaurantServiceInterface
{
    public function get(object $request): QueryBuilder;

    public function store(RestaurantRequest $request): void;

    public function update(RestaurantRequest $request, Restaurant $restaurant): void;

    public function delete(string $id): void;

    public function deleteMultiple(array $ids): void;

    public function restore(string $id): void;

    public function restoreMultiple(array $ids): void;
}
