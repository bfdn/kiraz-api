<?php

namespace App\Services\v1;

use App\Core\ServiceResponse;
use App\Models\Order;
use App\Models\OrderItems;

class OrderService
{
    // public User $users;

    public function __construct(public Order $order, public OrderItems $orderItems) {}

    public function getAll(): ServiceResponse
    {
        $orders = $this->order->with('orderItems')->get();
        return new ServiceResponse(true, 'Orders found', ['orders' => $orders], 200);
    }

    public function getById(int $id): ServiceResponse
    {
        // $order = $this->order->find($id);
        $order = $this->order->with('orderItems')->find($id);
        if (!$order) {
            return new ServiceResponse(false, 'Order not found', null, 404);
        }
        return new ServiceResponse(true, 'Order found', ['order' => $order], 200);
    }

    public function create(array $data): ServiceResponse
    {
        $products = $data['products'];
        unset($data['products']);
        $data['order_no'] = $this->generateUniqueCode();
        $data['user_id'] = auth('api')->user()->id;

        $order = $this->order->create($data);


        if (!empty($products)) {
            foreach ($products as $product) {
                $order->orderItems()->create([
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'total_price' => $product['qty'] * $product['price'],
                    'tax' => 20,
                    'tax_price' => $product['qty'] * $product['price'] * 0.20,
                ]);
            }
        }

        return new ServiceResponse(true, 'Order created successfully', ['order' => $order], 200);
    }

    public function update(int $id, array $data): ServiceResponse
    {
        $order = $this->order->find($id);
        if (!$order) {
            return new ServiceResponse(false, 'Order not found', null, 404);
        }

        $order->update($data);

        return new ServiceResponse(true, 'Order updated successfully', ['order' => $order], 200);
    }

    public function delete(int $id): ServiceResponse
    {
        $order = $this->order->find($id);
        if (!$order) {
            return new ServiceResponse(false, 'Order not found', null, 404);
        }

        $order->delete();

        return new ServiceResponse(true, 'Order deleted successfully', null, 200);
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Order::where("order_no", "=", $code)->first());

        return $code;
    }
}
