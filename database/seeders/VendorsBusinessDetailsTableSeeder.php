<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorBusinessDetailsRecords = [
            ['id' =>1, 'vendor_id' =>1, 'shop_name' =>'John Electronics Store', 'shop_address' =>'Faydabad', 'shop_city' =>'Uttara', 'shop_state' =>'Dhaka', 'shop_country' =>'Bangladesh', 'shop_pincode' =>'110001', 'shop_mobile' =>'01742712993', 'shop_website' =>'mdtohin.epizy.com', 'shop_email' =>'john@gmail.com', 'address_proof' =>'Passport', 'address_proof_image' =>'test.jpg', 'business_license_number' =>'12345326145', 'gst_number' =>'9532147852', 'pan_number' =>'1478452125']
        ];
        VendorsBusinessDetails::insert($vendorBusinessDetailsRecords);
    }
}