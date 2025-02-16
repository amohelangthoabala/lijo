<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\RestaurantEmployee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantEmployeeFactory extends Factory
{
    protected $model = RestaurantEmployee::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id ?? Restaurant::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
