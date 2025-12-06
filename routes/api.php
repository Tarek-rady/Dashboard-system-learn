<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Route;





Route::post('login' , [AuthController::class , 'login']);


Route::middleware('auth:sanctum')->group(function () {





});


Route::get('home' , [HomeController::class , 'home']);
