<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuleRequest;
use App\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RuleController extends Controller
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
        $all = Rule::all();
        return new JsonResponse($all, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RuleRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $object = Rule::create($data);
        return new JsonResponse($object, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Rule $rule, RuleRequest $request)
    {
        $data = [];
        foreach (json_decode($request->getContent()) as $k => $v) {
            $data[$k] = $v;
        };
        $rule->update($data);
        return new JsonResponse($rule, JsonResponse::HTTP_OK);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Rule $rule)
    {
        Rule::destroy($rule->id);
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
