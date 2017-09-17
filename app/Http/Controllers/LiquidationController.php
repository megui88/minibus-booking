<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Chauffeur;
use App\Http\Requests\BaseSettingRequest;
use App\Http\Requests\LiquidationRequest;
use App\Liquidation;
use App\Route;
use App\Service;
use App\TypeTrip;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiquidationController extends Controller
{
    private $routes;
    private $chauffeurs;
    private $vehicles;
    private $typeTrip;
    private $agencies;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $all = Liquidation::all();
        return new JsonResponse($all, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LiquidationRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };

        $services = Service::where('enabled', '=', true)
            ->where('agency_id', '=', $data['agency_id'])
            ->whereBetween('date', [
                (new Carbon($data['date_init']))->format('Y-m-d'),
                (new Carbon($data['date_end']))->format('Y-m-d')
            ])
            ->get();
        $data['total'] = 0;
        $data['tax'] = 0;
        $data['services'] = [];

        foreach ($services as $service) {
            $data['total'] += $service->paying;
            $data['tax'] += $service->tax;
            $data['services'] [] = [
                'date' => $service->date,
                'route' => $this->getRoute($service->route_id),
                'courier' => $service->courier,
                'chauffeur' => $this->getChauffeur($service->chauffeur_id),
                'vehicle' => $this->getVehicle($service->vehicle_id),
                'tax' => $service->tax,
                'paying' => $service->paying,
                'passengers' => $service->passengers,
                'typeTrip' => $this->getTypeTrip($service->type_trip_id),
                'agency' => $this->getAgency($service->agency_id),
                'turn' => $service->turn,
                'hour' => $service->hour,
            ];
        }

        $object = Liquidation::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Liquidation $liquidation)
    {
        Liquidation::destroy($liquidation->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }


    private function getRoute($id)
    {
        if(is_null($id)){
            return '';
        }
        if (!empty($this->routes[$id])) {
            return $this->routes[$id];
        }
        return $this->routes[$id] = Route::find($id)->name;
    }

    private function getAgency($id)
    {
        if(is_null($id)){
            return '';
        }
        if (!empty($this->agencies[$id])) {
            return $this->agencies[$id];
        }
        return $this->agencies[$id] = Agency::find($id)->name;
    }

    private function getTypeTrip($id)
    {
        if(is_null($id)){
            return '';
        }
        if (!empty($this->typeTrip[$id])) {
            return $this->typeTrip[$id];
        }
        return $this->typeTrip[$id] = TypeTrip::find($id)->name;
    }

    private function getVehicle($id)
    {
        if(is_null($id)){
            return '';
        }
        if (!empty($this->vehicles[$id])) {
            return $this->vehicles[$id];
        }
        return $this->vehicles[$id] = Vehicle::find($id)->name;
    }

    private function getChauffeur($id)
    {
        if(is_null($id)){
            return '';
        }
        if (!empty($this->chauffeurs[$id])) {
            return $this->chauffeurs[$id];
        }
        return $this->chauffeurs[$id] = Chauffeur::find($id)->name;
    }
}
