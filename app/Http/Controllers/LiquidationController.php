<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSettingRequest;
use App\Http\Requests\LiquidationRequest;
use App\Liquidation;
use App\Route;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LiquidationController extends Controller
{
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
        $data['services'] = [];

        foreach ($services as $service) {
            $data['total'] += $service->paying;
            $data['services'] [] = $service->toArray();
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
}
