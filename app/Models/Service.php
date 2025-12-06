<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $guarded = [];

    public function scopeCard($q){
      $q->select([ 'id' , 'name' , 'is_active' , 'category_id' , 'price' , 'created_at' ]);
    }

    public function category(){ return $this->belongsTo(Category::class) ;}

    protected static function booted()
    {
        static::addGlobalScope('active' , function($q){
           $q->where('is_active' , 1);
        });

   


    }


   protected function casts() : array {

      return [
         'is_active' =>'boolean' ,
      ];
   }




}
