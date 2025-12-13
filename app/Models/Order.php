<?php

namespace App\Models;

use App\Enums\PaymentEnum;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];

    public function scopeCardFields($q){

        return  $q->select(
            [
                'id' , 'user_id' , 'status' , 'code' , 'payment' , 'cost' , 'total_discount' , 'tax' ,
                 'total' , 'time_type' , 'res_type' , 'date' , 'start_time' ,
                'end_time' , 'lat' , 'lng' , 'location' , 'created_at'
            ]
        );

    }

    public function vendor(){ return $this->belongsTo(Vendor::class);}
    public function user(){ return $this->belongsTo(User::class);}
    public function items(){ return $this->hasMany(Item::class , 'order_id');}



    protected static function booted(){
        static::observe(OrderObserver::class);
    }


    protected $casts = [
        'payment' => PaymentEnum::class
    ];

}
