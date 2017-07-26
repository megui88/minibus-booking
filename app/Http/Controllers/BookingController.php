<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;

class BookingController extends Controller
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
        $services = DB::table('services');

        $filters = $request->get('filter', []);
        foreach ($filters as $column => $value) {
            $value = ('false' == $value) ? false
                : ('true' == $value) ? true
                    : ('null' == $value) ? null
                        : $value;
            $services->where($column, '=', $value);
        }

        $filters = $request->get('filterOr', []);
        foreach ($filters as $column => $value) {
            $value = ('false' == $value) ? false
                : ('true' == $value) ? true
                    : ('null' == $value) ? null
                        : $value;
            $services->whereOr($column, '=', $value);
        }

        return new JsonResponse($services->get(), JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ServiceRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = ('null' === $v) ? null : $v;
        };
        $service = Service::create($data);
        return new JsonResponse($service, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Service $service, ServiceRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = ('null' === $v) ? null : $v;
        };
        $service->update($data);
        return new JsonResponse($service, JsonResponse::HTTP_OK);
    }
}
