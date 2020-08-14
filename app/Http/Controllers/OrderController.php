<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\OrderStoreRequest;
use App\Order;
use App\OrderDetail;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::with('subcategories')->get();
        $products->map(function ($product) {
            $product['image'] = $product->image;
            return $product;
        });

        return inertia()->render('Dashboard/orders/create', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        $request->validated();

        $order = Order::create([
            'customer_phone' => $request->customer_phone,
            'customer_alt_phone' => $request->customer_alt_phone,
            'customer_address' => $request->customer_address,
            'discount' => $request->discount,
            'user_id' => auth()->id(),
        ]);

        $order->setOrderDetails($request->order_details);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function approve(Request $request, Order $order){

        $order->update([
            'added_price' => $request->added_price,
            'delivery_price' => $request->delivery_price,
            'delivery_man_id' => $request->delivery_man_id,
        ]);
        $order->setApproveTotalPrice();

    }


}


