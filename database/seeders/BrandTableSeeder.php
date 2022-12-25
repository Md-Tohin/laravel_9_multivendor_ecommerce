<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $brandRecords = [
            ['id'=>1, 'name'=>'Pakija','status'=>1],
            ['id'=>2, 'name'=>'Dell','status'=>1],
            ['id'=>3, 'name'=>'Hp','status'=>1],
            ['id'=>4, 'name'=>'Nokia','status'=>1]
        ];
        Brand::insert($brandRecords);
    }
}
