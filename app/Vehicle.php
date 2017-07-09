<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'chauffeur_id'
    ];

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id', 'id');
    }
}
