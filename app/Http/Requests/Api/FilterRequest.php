<?php

namespace App\Http\Requests\Api;

use App\Enums\OrderStatusEnum;
use App\Enums\ResTimeEnum;
use App\Enums\ResTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'user_id'  => ['nullable' , 'integer' , 'exists:users,id'] ,
            'status'   => ['nullable' , 'integer' , Rule::in(OrderStatusEnum::values())] ,
            'time_type'=> ['nullable' , 'integer' , Rule::in(ResTimeEnum::values())] ,
            'res_type' => ['nullable' , 'integer' , Rule::in(ResTypeEnum::values())] ,

            'search'   => ['nullable'] ,
            'total'    => ['nullable' , 'numeric'] ,
            'date'     => ['nullable' , 'date_format:Y-m-d'] ,
            'end_date' => ['nullable' , 'date_format:Y-m-d' , 'after:date' ] ,
            'per_page' => ['nullable' , 'integer' ]

        ];
    }
}
