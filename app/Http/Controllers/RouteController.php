<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSettingRequest;
use App\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
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
        $all = Route::all();
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
        $object = Route::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Route $route, BaseSettingRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $route->update($data);
        return new JsonResponse($route, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Route $route)
    {
        Route::destroy($route->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
