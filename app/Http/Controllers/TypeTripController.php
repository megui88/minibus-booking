<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSettingRequest;
use App\TypeTrip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeTripController extends Controller
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
        $all = TypeTrip::all();
        return new JsonResponse($all, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BaseSettingRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $object = TypeTrip::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TypeTrip $typeTrip, BaseSettingRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $typeTrip->update($data);
        return new JsonResponse($typeTrip, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(TypeTrip $typeTrip)
    {
        TypeTrip::destroy($typeTrip->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
