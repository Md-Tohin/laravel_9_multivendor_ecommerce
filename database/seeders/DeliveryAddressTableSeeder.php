<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['user_id' => 13, 'name' => 'Karim', 'address' => 'Faydabat, dokkhinkhan', 'city' => 'Dhaka', 'state' => 'Bangladesh', 'country' => 'Bangladesh', 'pincode' => '880', 'mobile' => '01854229083', 'status' => 1],
            ['user_id' => 13, 'name' => 'Karim', 'address' => 'Gopalpur, Madargonj', 'city' => 'Jamalpur', 'state' => 'Bangladesh', 'country' => 'Bangladesh', 'pincode' => '880', 'mobile' => '01682885337', 'status' => 1]
        ];

        DeliveryAddress::insert($records);
    }
}
