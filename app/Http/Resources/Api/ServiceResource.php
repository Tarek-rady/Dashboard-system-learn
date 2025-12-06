<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
          'id'           => $this->id ,
          'name'         => $this->name ,
          'category_id'  => [
            'id' => $this->category?->id ,
            'name' => $this->category?->name ,
          ] ,
          'is_active'   => $this->is_active ,

          'price'        => $this->price ,
          'created_at'   => $this->created_at?->format('Y-m-d')
        ];
    }
}
