<?php

namespace App\Http\Controllers\Api\v1;

use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderController\v1\OrderDestroyRequest;
use App\Http\Requests\Api\OrderController\v1\OrderIndexRequest;
use App\Http\Requests\Api\OrderController\v1\OrderShowRequest;
use App\Http\Requests\Api\OrderController\v1\OrderStoreRequest;
use App\Services\v1\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HttpResponse;

    public function __construct(private OrderService $orderService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(OrderIndexRequest $request)
    {
        $response = $this->orderService->getAll();
        return $this->httpResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        \DB::beginTransaction();
        try {
            // dd($request->all());
            $response = $this->orderService->create($request->only([
                'order_no',
                'payment_method',
                'order_status',
                'total_price',
                'total_qty',
                'tax_total_price',
                'name',
                'company',
                'address',
                'email',
                'phone',
                'notes',
                'products',
            ]));

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
            // return $th->getMessage();
            // return $this->httpResponse($th->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderShowRequest $request, string $id)
    {
        $response = $this->orderService->getById($id);
        return $this->httpResponse($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDestroyRequest $request, string $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->orderService->delete($id);

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
            // return $th->getMessage();
            // return $this->httpResponse($th->getMessage(), 422);
        }
    }
}
