<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected ? string $scope ;

    public function __construct($resource , string $scope = 'mini')
    {
        parent::__construct($resource);
        $this->scope = $scope;
    }


    public function toArray(Request $request): array
    {
        return match($this->scope){
            'micro' => $this->micro() ,
            'mini'  => $this->mini() ,
            default => $this->mini()
        };
    }

    private function micro(){
      return [
        'id'        => $this->id ,
        'name'      => $this->full_name ,
        'img'       => $this->img ? asset("storage/{$this->img}") : null,
      ];
    }

    private function mini(){

        return array_merge($this->micro() , [

            'phone'     => $this->phone ,
            'email'     => $this->email ,
            'fcm_token' => $this->fcm_token ,
            'city'      => $this->city_id ,
        ]);
    }
}
