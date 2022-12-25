<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorBankDetailsRecords = [
            ['id' =>1, 'vendor_id' =>1, 'account_holder_name' =>'Jhon', 'bank_name' =>'Prime Bank', 'account_number' =>'121054919875', 'bank_ifsc_code' =>'1254879652']
        ];
        VendorsBankDetails::insert($vendorBankDetailsRecords);
    }
}