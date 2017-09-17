<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_init',
        'date_end',
        'agency_id',
        'services',
        'tax',
        'total',
    ];

    protected $casts = [
      'services' => 'array'
    ];
}