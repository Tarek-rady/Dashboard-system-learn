<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;



    protected $guarded = [];
    protected $appends = ['full_name'];

    public function scopeCard($q){

       $q->select(['id' , 'f_name' , 'l_name' , 'phone' ,  'email' , 'img' , 'fcm_token' , 'city_id' ]);
    }


    public function city(){ return $this->belongsTo(City::class) ;}

    protected function fullName() : Attribute{

        return Attribute::make(
            get: fn() => "{$this->f_name} {$this->l_name}"
        );
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
