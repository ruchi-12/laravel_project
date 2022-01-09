<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantImage extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'image',
        'updated_at',
        'deleted_at',
    ];

    public function images()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getImageAttribute($value)
    {
        return env('APP_URL') . $this->attributes['image'];
    }
}
