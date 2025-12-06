<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    public function order(){ return $this->belongsTo(Order::class);}
    public function service(){ return $this->belongsTo(Service::class);}
    public function vendor(){ return $this->belongsTo(Vendor::class);}
    public function user(){ return $this->belongsTo(User::class);}
}
