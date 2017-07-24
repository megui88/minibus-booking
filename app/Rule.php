<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agency_id',
        'turn',
        'route_id',
        'type_trip_id',
        'number_passengers',
        'priority',
        'price',
    ];
}
