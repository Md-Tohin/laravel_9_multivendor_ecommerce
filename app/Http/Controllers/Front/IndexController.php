<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    //  index
    public function index(){
        $sliderBanners = Banner::where('type', "Slider")->where('status', 1)->get()->toArray();
        $fixBanners = Banner::where('type', "Fix")->where('status', 1)->get()->toArray();
        $newProducts = Product::orderBy('id', "desc")->where('status', 1)->limit(8)->get()->toArray();
        $bestSelllers = Product::where('is_bestseller', 'Yes')->where('status', 1)->inRandomOrder()->get()->toArray();
        $discountProducts = Product::where('product_discount', '>', 0)->where('status', 1)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where('is_featured', 'Yes')->where('status', 1)->inRandomOrder()->get()->toArray();
        // echo "<pre>"; print_r($bestSelllers); die;
        return view('front.index')->with(compact('sliderBanners','fixBanners', 'newProducts', 'bestSelllers', 'discountProducts', 'featuredProducts'));
    }
}
