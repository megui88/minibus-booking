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
        'turn',
        'hour',
        'route_id',
        'date',
        'vehicle_id',
        'chauffeur_id',
        'courier',
        'agency_id',
        'passengers',
        'type_trip_id',
        'paying',
        'tax',
        'enabled'
    ];


    protected static function boot()
    {
        parent::boot();
        self::updating(function ($entity) {
            $complete = true;
            foreach (['tax', 'route_id', 'agency_id', 'passengers', 'type_trip_id'] as $column) {
                if (empty($entity->$column)) {
                    $complete = !empty($entity->$column);
                    break;
                }
            }

            if ($complete) {
                $rule = Rule::searchRule($entity);
                $entity->paying = $rule->price;
            }
        });

    }

}
