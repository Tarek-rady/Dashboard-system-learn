<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];

    public function vendor(){ return $this->belongsTo(Vendor::class);}
    public function user(){ return $this->belongsTo(User::class);}
    public function items(){ return $this->hasMany(Item::class , 'order_id');}



    protected static function booted(){
        static::observe(OrderObserver::class);
    }

}
