<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'owner_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
