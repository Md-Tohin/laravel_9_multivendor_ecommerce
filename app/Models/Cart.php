<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Session;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems(){
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

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}