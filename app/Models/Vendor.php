<?php

namespace App\Models;
use App\Models\VendorsBusinessDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendorBusinessDetails(){
        return $this->belongsTo(VendorsBusinessDetails::class, 'id', 'vendor_id');
    }

    public static function getVendorShopName($vendor_id){
        $getVendorShopName = VendorsBusinessDetails::select('shop_name')->where('vendor_id', $vendor_id)->first()->toArray();
        return $getVendorShopName;
    }
}
