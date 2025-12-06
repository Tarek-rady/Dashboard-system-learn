<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Trait\ApiResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ->paginate(20);

        $data = [
           'services' => ServiceResource::collection($services) ,
           'paginatation' => $services->toArrayPaginate()
        ];

        return $this->ApiResponse($data , '' , 200) ;
    }


    // public function home(){
    //   $sum = DB::table('services')->sum('price');
    //   $count = DB::table('services')->count();
    //   $max = DB::table('services')->max('price');
    //   $min = DB::table('services')->min('price');
    //    //   $avg = DB::table('services')->avg('degree');


    //   $data = [
    //     'sum'      => $sum ,
    //     'count'    => $count ,
    //     'max'      => $max ,
    //     'min'      => $min ,
    //   ];


    //   return $this->ApiResponse($data);
    // }
}
