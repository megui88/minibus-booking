<?php
namespace App\Http\Requests;

use App\Service;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class LiquidationRequest extends FormRequest
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
            'date_init' => 'required',
            'date_end' => 'required',
            'agency_id' => 'required',
        ];
    }


    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function () use ($validator) {

            $input = $validator->getData();

            $services = Service::where('enabled', '=', true)
                ->where('agency_id', '=', $input['agency_id'])
                ->whereBetween('date', [
                    (new Carbon($input['date_init']))->format('Y-m-d'),
                    (new Carbon($input['date_end']))->format('Y-m-d')
                ])
                ->where(function($q) {
                    $q->whereNull('type_trip_id')
                        ->orWhereNull('passengers');
                });

            if ($services->count() > 0) {
                $validator->errors()->add('agency_id',
                    'Para este rango de fechas y agencia hay servicios incompletos');
            }
        });

        return $validator;
    }

}