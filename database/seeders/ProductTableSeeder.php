<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $productRecords = [
            ['id'=>1, 'section_id'=>2,'category_id'=>4,'brand_id'=>4, 'vendor_id'=>1, 'admin_id'=>2, 'admin_type'=>'vendor', 'product_name'=>'Nokia S-720', 'product_code'=>'NP001', 'product_color'=>'Black', 'product_price'=>2500, 'product_discount'=>5, 'product_weight'=>80, 'product_image'=>'', 'product_video'=>'','description'=>'', 'meta_title'=>'', 'meta_description'=>'', 'meta_keywords'=>'', 'is_featured'=>'Yes', 'is_bestseller'=>'Yes', 'status'=>1],
        ];
        Product::insert($productRecords);
    }
}
