<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTrip extends Model
{
    protected $table = 'types_trips';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
