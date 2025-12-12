<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Route;





Route::post('login' , [AuthController::class , 'login']);


Route::middleware('auth:sanctum')->group(function () {


    Route::post('create-reservation' , [ReservationController::class , 'create']);



});


Route::get('home'            , [HomeController::class , 'home']);
Route::post('add-tag'        , [HomeController::class , 'add_tag']);
Route::get('get-tag/{id}'    , [HomeController::class , 'get_tag']);
Route::post('update-tag/{id}'    , [HomeController::class , 'update_tag']);
Route::delete('delete-tag/{id}'    , [HomeController::class , 'delete_tag']);
Route::get('payment-methods' , [ReservationController::class , 'payment']);
