<?php

namespace App\Trait;


use Illuminate\Support\Facades\Validator;

/**
 * Tarit for standard Api Response
 * [
 * 'data',
 * 'message',
 * 'status'
 * ]
 */


trait ApiResonseTrait
{

     public $paginateNumber = 10;

    public function ApiResponse($data = [] , $message = null , $code = 200)
    {
            $array =
            [
                'data'    => $data,
                'message' => $message,
                'status'  => in_array($code ,$this->successCode())? true : false
            ];

            return response()->json($array,$code);
    }

    public function successCode()
    {

        return [
            200 ,201 ,202
        ];

    }

    public function notFoundResponse()
    {

        return $this->ApiResponse([] , __('api.not_found') , 404);

    }

    public function apiValidation($request , $array)
    {

        $validate = Validator::make($request->all() , $array);

        if ($validate->fails())
        {
            return $this->ApiResponse([] , $validate->errors() , 422);
        }

    }



}
