<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSettingRequest;
use App\Agency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgencyController extends Controller
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
        $all = Agency::all();
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
        $object = Agency::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Agency $agency, BaseSettingRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $agency->update($data);
        return new JsonResponse($agency, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Agency $agency)
    {
        Agency::destroy($agency->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
