<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Orders\MakeOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    protected OrderRepository $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $userRepository)
    {
        $user = auth()->user();
        $orders = $userRepository->findUserOrders($user->id);

        return ResponseData::paginate(data: $orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MakeOrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MakeOrderRequest $request)
    {
        $user = auth()->user();

        $orders = $request->validated();

        $product_ids = Arr::pluck($orders['orders'], 'product_id');
        $products = Product::query()->whereIn('id', $product_ids)->get();

        $orders['totalPrice'] = 0;
        foreach ($products as $key => $productItem) {
            foreach ($orders['orders'] as $k => $orderItem){
                if ($orderItem['product_id'] == $productItem->id){
                    $orders['orders'][$k]['price'] = $productItem->price;
                    $orders['totalPrice'] += $productItem->price * $orders['orders'][$k]['qty'];
                }
            }
        }

        $order = $this->order->create([
            'total_price' => $orders['totalPrice'],
            'user_id' => $user->id
        ]);

        foreach ($orders['orders'] as $item){
            $order->products()->attach($item['product_id'], ['option_id' => $item['option_id'], 'qty' => $item['qty'], 'price' => $item['price']]);
        }

        return ResponseData::success(data: $order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userAuth = auth()->user();
        $order = $this->order->findUserOrder($id, $userAuth->id);
        if (is_null($order))
            return ResponseData::error('This order not for you');

        return ResponseData::success(data: $order);
    }
}
