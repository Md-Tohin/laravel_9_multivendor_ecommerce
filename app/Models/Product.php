<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductsAttribute;

class Product extends Model
{
    use HasFactory;
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id')->with('vendorBusinessDetails');
    }
    
    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_price','product_discount', 'category_id')->where('id', $product_id)->first();
        $proDetails = json_decode(json_encode($proDetails), true);
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if ($proDetails['product_discount'] > 0) {
            //  If product discount is added from the admin panel
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] * $proDetails['product_discount'] / 100);
        } 
        else if ($catDetails['category_discount'] > 0) {
           //  if product discount is added from the admin panel
           $discounted_price = $proDetails['product_price'] - ($proDetails['product_price'] * $catDetails['category_discount'] / 100);
        }        
        else {
           $discounted_price = 0; 
        }
        
        return $discounted_price;
    }

    public static function getDiscountAttributePrice($product_id, $size){
        $proAttrPrice = ProductsAttribute::where(['product_id'=> $product_id, 'size'=> $size])->first()->toArray();
        $proDetails = Product::select('product_discount', 'category_id')->where('id', $product_id)->first();
        $proDetails = json_decode(json_encode($proDetails), true);
        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if ($proDetails['product_discount'] > 0) {
            //  If product discount is added from the admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $proDetails['product_discount'] / 100);
            $discount = $proAttrPrice['price'] - $final_price;
        } 
        else if ($catDetails['category_discount'] > 0) {
           //  if product discount is added from the admin panel
           $final_price = $proAttrPrice['price'] - ($proAttrPrice['price'] * $catDetails['category_discount'] / 100);
           $discount = $proAttrPrice['price'] - $final_price;
        }        
        else {
           $final_price = $proAttrPrice['price']; 
           $discount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'], 'final_price'=>$final_price, 'discount'=>$discount);
    }

    public static function isProductNew($product_id){
        //  Get Last 3 Products
        $productIds = Product::select('id')->where('status', 1)->orderBy('id', 'DESC')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds), true);
        // dd($productIds);
        if (in_array($product_id , $productIds)) {
            $isProductNew = "Yes";
        } else {
            $isProductNew = "No";
        }  
        return $isProductNew;      
    }

    public static function getProductImage($product_id){
        $getProductImage = Product::select('product_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }

}
