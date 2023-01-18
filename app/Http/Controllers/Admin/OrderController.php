<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Notifications\UpdateOrderStatusNotification;
use App\Repositories\OrderRepository;
use App\Services\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    protected OrderRepository $order;

    public function __construct(OrderRepository$order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->paginate();
        return ResponseData::paginate(data: $orders);
    }

    public function show($id)
    {
        $order = $this->order->find($id);
        return ResponseData::success(data: $order);
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        $order = $this->order->find($id);
        $this->order->update($order, $request->validated());

        Notification::send($order->user, new UpdateOrderStatusNotification($order));
        return ResponseData::success(data: $order);
    }
}
