<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Models\Tag;
use App\Trait\ApiResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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


    public function add_tag(Request $request){

        $request->validate([
            'name' => 'required' ,
            'file' => 'required|file|max:2048',
        ]);



        $path = $request->file('file')->store('tags' , 'public');

        $data['img'] = $path ;
        $data['name'] = $request->name;



        $tag = Tag::create($data);

        return [
          'id' => $tag?->id
        ];




    }


    public function get_tag($id){
       $tag = Tag::find($id);

       return [
            'name' => $tag->name ,
            'img'  =>Storage::disk('public')->url($tag->img),
       ];
    }


    public function update_tag(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name'        => 'nullable|string|max:255',
            'file'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_flag' => 'nullable|boolean',
        ]);

        $data = [];


        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }


        if ($request->boolean('remove_flag') && !$request->hasFile('file')) {
            if ($tag->img && Storage::disk('public')->exists($tag->img)) {
                Storage::disk('public')->delete($tag->img);
            }
            $data['img'] = null;
        }


        if ($request->hasFile('file')) {

            if ($tag->img && Storage::disk('public')->exists($tag->img)) {
                Storage::disk('public')->delete($tag->img);
            }

            $data['img'] = $request->file('file')->store('tags', 'public');
        }


        if (empty($data)) {
            return response()->json([
                'message' => 'No data to update',
            ], 422);
        }

        $tag->update($data);

        return response()->json([
            'id'   => $tag->id,
            'name' => $tag->name,
            'img'  => $tag->img
                ? Storage::disk('public')->url($tag->img)
                : null,
        ]);
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
