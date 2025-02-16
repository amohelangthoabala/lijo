<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantEmployee;

class RestaurantEmployeeSeeder extends Seeder
{
    public function run()
    {
        RestaurantEmployee::factory()->count(20)->create();
    }
}
