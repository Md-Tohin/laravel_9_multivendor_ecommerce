<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;
use App\Models\VendorsBankDetails;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guard = 'admin';
    
    public function vendorPersonal()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorBusiness()
    {
        return $this->belongsTo(VendorsBusinessDetails::class, 'vendor_id');
    }

    public function vendorBank()
    {
        return $this->belongsTo(VendorsBankDetails::class, 'vendor_id');
    }
}
