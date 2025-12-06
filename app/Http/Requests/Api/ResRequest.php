<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentEnum;
use App\Enums\ResTimeEnum;
use App\Enums\ResTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (is_string($this->services)) {
            $decoded = json_decode($this->services, true);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge([
                    'services' => $decoded,
                ]);
            }
        }
    }


    public function rules(Request $request): array
    {



        return [

            'payment'       => ['required' , Rule::in(PaymentEnum::values())] ,
            'time_type'     => ['required' , Rule::in(ResTimeEnum::values())] ,
            'res_type'      => ['required' , Rule::in(ResTypeEnum::values())] ,
            'date'          => ['required' , 'date'] ,
            'start_time'    => ['required' , 'date_format:H:i'] ,
            'end_time'      => ['required' , 'date_format:H:i' , 'after:start_time'] ,
            'lat'           => ['required' , 'numeric'] ,
            'lng'           => ['required' , 'numeric'] ,
            'location'      => ['required' , 'string'] ,
            'services'      => ['array'] ,
            'services.*'     => ['required' , Rule::exists('services', 'id')->where('is_active', 1) ]

        ];
    }
}
