<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //  Orders
    public function orders($id=null){
        if (empty($id)) {
            $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get()->toArray();            
            return view('front.orders.orders')->with(compact('orders'));
        } else {
            $orderDetails = Order::with('orders_products')->where('id', $id)->first()->toArray();
            // echo "<pre>"; print_r($orderDetails); die;
            return view('front.orders.orders_details')->with(compact('orderDetails'));
        }
        
        
    }
}
