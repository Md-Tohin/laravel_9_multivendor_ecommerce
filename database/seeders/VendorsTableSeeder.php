<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vendorRecords = [
            ['id'=>1, 'name'=>'John', 'address'=>'CP-112', 'city'=>'New Delhi', 'state'=>'Selhi', 'country'=>'India', 'pincode'=>'10001', 'mobile'=>'01742712993', 'email'=>'john@gmail.com', 'status'=>'0']
        ];
        Vendor::insert($vendorRecords);
    }
}
