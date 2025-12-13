<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

   protected ? string $scope ;

    public function __construct($resource , string $scope = 'micro')
    {
        parent::__construct($resource);
        $this->scope = $scope;
    }


    public function toArray(Request $request): array
    {


        return match($this->scope){
            'micro' => $this->micro() ,
            'mini'  => $this->mini() ,
            default => $this->micro()
        };
    }

    private function micro(){
        return [
            'id'             => $this->id ,
            'user_id'        => $this->user_id ,
            'status'         => $this->status ,
            'code'           => $this->code ,
            'total'          => $this->total ,
            'time_type'      => $this->time_type ,
            'res_type'       => $this->res_type ,
            'created_at'     => $this->created_at->format('Y-m-d') ,
        ];
    }

    private function mini(){
        return array_merge($this->micro() ,  [
            'payment'        => $this->payment ,
            'cost'           => $this->cost ,
            'total_discount' => $this->total_discount ,
            'tax'            => $this->tax ,
            'date'           => $this->date ,
            'start_time'     => $this->start_time ,
            'end_time'       => $this->end_time ,
            'lat'            => $this->lat ,
            'lng'            => $this->lng ,
            'location'       => $this->location ,
        ]);
    }
}
