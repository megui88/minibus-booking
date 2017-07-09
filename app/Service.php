<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turn', 'hour', 'route_id', 'type_id', 'date', 'vehicle_id', 'chauffeur_id', 'courier', 'agency_id', 'passengers'
    ];

}
