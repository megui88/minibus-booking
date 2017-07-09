<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
