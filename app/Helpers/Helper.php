<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

function totalCartItems(){
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalCartItems = Cart::where('user_id', $user_id)->sum('quantity');
    }
    else{
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id', $session_id)->sum('quantity');
    }
    return $totalCartItems;
}

function getCartItems(){
    //  If user logged in / pick auth id of the user
   if (Auth::check()) {
        $getCartItems = Cart::with(['product'=>function($query){
            $query->select('id','category_id', 'product_name', 'product_code', 'product_color', 'product_image');
        }])->orderBy('id','desc')->where('user_id',Auth::user()->id)->get()->toArray();
   }
   else{
    $getCartItems = Cart::with(['product'=>function($query){
        $query->select('id','category_id', 'product_name', 'product_code', 'product_color', 'product_image');
    }])->orderBy('id', 'desc')->where('session_id',Session::get('session_id'))->get()->toArray();
   }
   return $getCartItems;
}