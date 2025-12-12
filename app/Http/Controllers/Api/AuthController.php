<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use App\Jobs\SendLoginOtpJob;
use App\Models\User;
use App\Services\AuthService;
use App\trait\ApiResonseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
       $this->authService = $authService;
    }
    use ApiResonseTrait;

    public function login(LoginRequest $request){
        $data = $request->validated();

        $user = $this->authService->attemptLogin($data);

        if(empty($user)) return $this->notFoundResponse();

        $this->sendMail($user);

        return $this->userResourcee($user);

    }



    private function sendMail($user){
        SendLoginOtpJob::dispatch(
          $user->email ,
          $user->f_name  ,
          1234 ,
        )->onQueue('emails');
    }






    private function userResourcee($user) : array {
        $token = $this->authService->generateToken($user);

        return $data = [
          'token' => $token ,
          'user'  => new UserResource($user , 'micro')
        ];
    }












}
