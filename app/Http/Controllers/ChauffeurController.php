<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseSettingRequest;
use App\Chauffeur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
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
        $all = Chauffeur::all();
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
        $object = Chauffeur::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Chauffeur $chauffeur, BaseSettingRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $chauffeur->update($data);
        return new JsonResponse($chauffeur, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Chauffeur $chauffeur)
    {
        Chauffeur::destroy($chauffeur->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
