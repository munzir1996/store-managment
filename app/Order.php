<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $with = ['orderDetails'];

    public function setOrderDetails($orderDetails)
    {
        foreach ($orderDetails as $orderDetail) {
            $orderDetail = OrderDetail::create([
                'product_id' => $orderDetail['product_id'],
                'order_id' => $this->id,
                'quantity' => $orderDetail['quantity'],
            ]);
            $orderDetail->product->decrement('stock', $orderDetail->quantity);
            $this->total_price += $orderDetail->product->total_price * $orderDetail->quantity;
        }
        if (!empty($this->discount)) {
            $this->total_price -= $this->discount;
        }
        $this->save();
    }

    public function setApproveTotalPrice(){

        $this->total_price += $this->added_price + $this->delivery_price;
        $this->save();

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryMan()
    {
        return $this->belongsTo('App\User', 'delivery_man_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


}
