<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Trait\ApiResonseTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    use ApiResonseTrait;

    public function home(){

        $services = Service::query()
        ->with('category')
        ->card()
        // ->whereBetween('price' , [50 , 60])
        ->whereNotNull('category_id')
        // ->whereMonth('created_at' , 12)
        // ->whereColumn('price' , '<' , 70)
        ->withoutGlobalScope('category')

        ->latest()
        ->paginate(20) ;

        $data = [
           'services' => ServiceResource::collection($services) ,
           'paginatation' => $services->toArrayPaginate()
        ];

        return $this->ApiResponse($data , '' , 200) ;
    }
}
