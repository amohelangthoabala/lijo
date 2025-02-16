<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantEmployee extends Model
{
    use HasFactory;
    use HasUuids;

    public $guarded = [];

    protected $table = 'restaurant_employees';

    protected $fillable = ['restaurant_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
