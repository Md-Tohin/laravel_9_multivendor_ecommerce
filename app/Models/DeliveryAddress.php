<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function deliveryAddresses(){
        $deliveryAddresses = DeliveryAddress::where('user_id', Auth::user()->id)->get()->toArray();
        return $deliveryAddresses;
    }
}
