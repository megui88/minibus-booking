<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'agency_id' => 'required',
            'turn' => 'required',
            'route_id' => 'required',
            'type_trip_id' => 'required',
            'number_passengers' => 'required',
            'price' => 'required',
            'priority' => 'required',
        ];
    }

}