<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public static function searchRule(Service $service)
    {
        $rule = DB::table('rules');
        //Agency
        $rule->where(function ($q) use ($service) {
            $q->where('agency_id', '=', $service->agency_id)
                ->orWhere('agency_id', '=', 'ANY');
        });
        //Turn
        $rule->where(function ($q) use ($service) {
            $q->where('turn', '=', $service->turn)
                ->orWhere('turn', '=', 'ANY');
        });
        //Route
        $rule->where(function ($q) use ($service) {
            $q->where('route_id', '=', $service->route_id)
                ->orWhere('route_id', '=', 'ANY');
        });
        //TypeTrip
        $rule->where(function ($q) use ($service) {
            $q->where('type_trip_id', '=', $service->type_trip_id)
                ->orWhere('type_trip_id', '=', 'ANY');
        });
        //Number Passengers
        $rule->where(function ($q) use ($service) {
            $q->where('number_passengers', '>=', $service->passengers)
                ->orWhere('number_passengers', '=', '0');
        });
        $rule->orderBy('priority','ASC');

        return $rule->first();
    }
}
