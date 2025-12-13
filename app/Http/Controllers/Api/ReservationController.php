<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterRequest;
use App\Http\Requests\Api\ResRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Services\FirebaseService;
use App\Services\ReservationService;
use App\Support\PaginationHelpers;
use App\Trait\ApiResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    // ORM
    public function get_reservations(FilterRequest $request)
    {
        $data = $request->validated();

        $perPage = min(max((int)($data['per_page'] ?? 2), 1), 20);

        $orders = Order::query()
            ->cardFields()
            ->with([
                'user:id,f_name,l_name',
                'items:id,order_id,service_id,price'
            ])

            ->when($data['user_id'] ?? null,
                fn ($q, $userId) => $q->where('user_id', $userId)
            )

            ->when($data['status'] ?? null,
                fn ($q, $status) => $q->where('status', $status)
            )

            ->when($data['time_type'] ?? null,
                fn ($q, $timeType) => $q->where('time_type', $timeType)
            )

            ->when($data['res_type'] ?? null,
                fn ($q, $resType) => $q->where('res_type', $resType)
            )

            ->when(
                isset($data['date'], $data['end_date']),
                fn ($q) => $q->whereBetween('created_at', [
                    $data['date'],
                    $data['end_date']
                ])
            )

            ->when($data['search'] ?? null, function ($q, $search) {
                $q->where(function ($qq) use ($search) {

                    if (is_numeric($search)) {
                        $qq->where('id', $search);
                    }

                    $qq->orWhere('code', 'like', "{$search}%")
                    ->orWhereHas('user', fn ($u) =>
                            $u->where('f_name', 'like', "{$search}%")
                            ->orWhere('l_name', 'like', "{$search}%")
                    );
                });
            })

            ->orderByDesc('id')

            ->simplePaginate($perPage);

        return $this->ApiResponse([
            'orders'     => OrderResource::collection($orders, 'micro'),
            'pagination' => PaginationHelpers::meta($orders),
        ], '', 200);
    }



    // public function get_reservations(FilterRequest $request)
    // {
    //     $data = $request->validated();

    //     $perPage = min(max((int)($data['per_page'] ?? 10), 1), 20);

    //     $orders = DB::table('orders')
    //         ->select([
    //             'orders.id',
    //             'orders.user_id',
    //             'orders.status',
    //             'orders.code',
    //             'orders.payment',
    //             'orders.cost',
    //             'orders.total_discount',
    //             'orders.tax',
    //             'orders.total',
    //             'orders.time_type',
    //             'orders.res_type',
    //             'orders.date',
    //             'orders.start_time',
    //             'orders.end_time',
    //             'orders.lat',
    //             'orders.lng',
    //             'orders.location',
    //             'orders.created_at',

    //             // user fields (للـ search / response)
    //             'users.f_name',
    //             'users.l_name',
    //         ])

    //         ->leftJoin('users', 'users.id', '=', 'orders.user_id')

    //         ->when($data['user_id'] ?? null,
    //             fn ($q, $userId) => $q->where('orders.user_id', $userId)
    //         )

    //         ->when($data['status'] ?? null,
    //             fn ($q, $status) => $q->where('orders.status', $status)
    //         )

    //         ->when($data['time_type'] ?? null,
    //             fn ($q, $timeType) => $q->where('orders.time_type', $timeType)
    //         )

    //         ->when($data['res_type'] ?? null,
    //             fn ($q, $resType) => $q->where('orders.res_type', $resType)
    //         )

    //         ->when(
    //             isset($data['date'], $data['end_date']),
    //             fn ($q) => $q->whereBetween('orders.created_at', [
    //                 $data['date'],
    //                 $data['end_date'],
    //             ])
    //         )

    //         ->when($data['search'] ?? null, function ($q, $search) {
    //             $q->where(function ($qq) use ($search) {

    //                 if (is_numeric($search)) {
    //                     $qq->where('orders.id', (int)$search);
    //                 }

    //                 $qq->orWhere('orders.code', 'like', "{$search}%")
    //                 ->orWhere('users.f_name', 'like', "{$search}%")
    //                 ->orWhere('users.l_name', 'like', "{$search}%");
    //             });
    //         })

    //         ->orderByDesc('orders.created_at')

    //         ->paginate($perPage)
    //         ->withQueryString();

    //     return $this->ApiResponse([
    //         'orders'     => OrderResource::collection($orders, 'micro'),
    //         'pagination' => $orders->toArrayPaginate(),
    //     ], '', 200);
    // }


















    public function payment(){
        $payments = PaymentEnum::labels();
        return $this->ApiResponse($payments , '' , 200);
    }

}
