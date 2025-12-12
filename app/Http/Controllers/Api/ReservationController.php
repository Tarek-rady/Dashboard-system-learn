<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ResRequest;
use App\Services\FirebaseService;
use App\Services\ReservationService;
use App\Trait\ApiResonseTrait;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    use ApiResonseTrait;
    protected $resService;

    public function __construct( ReservationService $resService)
    {
        $this->resService = $resService ;
    }


    public function create(ResRequest $request)
    {

        $data = $request->except('services');
        $reservationId = $this->resService->createReservation($data, $request);
        return $this->ApiResponse([] , 'reservation created successfully' , 200);


    }

    public function payment(){
        $payments = PaymentEnum::labels();
        return $this->ApiResponse($payments , '' , 200);
    }

}
