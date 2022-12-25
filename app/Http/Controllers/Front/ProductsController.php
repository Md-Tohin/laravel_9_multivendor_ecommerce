<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Models\Vendor;
use App\Models\Cart;
use Session;
use DB;
use Auth;

class ProductsController extends Controller
{
    //  listing
    public function listing(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            // echo $url; die;
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);

                // Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $filter){
                    //  If filter id Selected
                    if (isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])) {
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }

                //  checking for Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderBy('products.id', 'desc');
                    }               
                    else if ($_GET['sort'] == "price_lowest") {
                        $categoryProducts->orderBy('products.product_price', 'asc');
                    }
                    else if ($_GET['sort'] == "price_highest") {
                        $categoryProducts->orderBy('products.product_price', 'desc');
                    }                
                    else if ($_GET['sort'] == "name_a_z") {
                        $categoryProducts->orderBy('products.product_name', 'asc');
                    }
                    else if ($_GET['sort'] == "name_z_a") {
                        $categoryProducts->orderBy('products.product_name', 'desc');
                    }             
                }

                //  checking for Size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                //  checking for Color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                //  checking for Price
                if (isset($data['price']) && !empty($data['price'])) {
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode('-', $price);                        
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0],$priceArr[1]])->pluck('id')->toArray();   
                    }
                    // echo "<pre>"; print_r($productIds); die;
                    $productIds = call_user_func_array('array_merge', $productIds);
                    $categoryProducts->whereIn('products.id', $productIds);
                    // echo "<pre>"; print_r($data); die;
                    // echo "<pre>"; print_r($productIds); die;
                    // $implodePrices = implode(' - ', $data['price']);
                    // $explodePrices = explode(' - ', $implodePrices);
                    // $min = reset($explodePrices);
                    // $max = end($explodePrices);                    
                    // $productIds = Product::select('id')->whereBetween('product_price', [$min, $max])->pluck('id')->toArray();
                    // $categoryProducts->whereIn('products.id', $productIds);
                }

                //  checking for Brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                // dd($categoryDetails);
                // dd($categoryProducts);          
                $categoryProducts = $categoryProducts->paginate(9);
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts', 'url'));
            } else {
                abort(404);
            }

        }
        else{
            $url = Route::getFacadeRoot()->current()->uri();
            // echo $url; die;
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);
                //  checking for Sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderBy('products.id', 'desc');
                    }               
                    else if ($_GET['sort'] == "price_lowest") {
                        $categoryProducts->orderBy('products.product_price', 'asc');
                    }
                    else if ($_GET['sort'] == "price_highest") {
                        $categoryProducts->orderBy('products.product_price', 'desc');
                    }                
                    else if ($_GET['sort'] == "name_a_z") {
                        $categoryProducts->orderBy('products.product_name', 'asc');
                    }
                    else if ($_GET['sort'] == "name_z_a") {
                        $categoryProducts->orderBy('products.product_name', 'desc');
                    }             
                }
                // dd($categoryDetails);
                // dd($categoryProducts);          
                $categoryProducts = $categoryProducts->paginate(9);
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts', 'url'));
            } else {
                abort(404);
            }
        }
        
        
    }

    //  Details 
    public function detail($id){
        $productDetails = Product::with(['section', 'category', 'brand', 'attributes'=>function($query){$query->where('stock','>',0)->where('status',1);}, 'images', 'vendor'])->find($id)->toArray();

        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        $totalStock = ProductsAttribute::where(['product_id'=> $id, 'status'=>1] )->sum('stock');

        $similarProducts = Product::with('brand')->where('category_id', $productDetails['category_id'])->where('status', 1)->where('id', '!=', $id)->limit(4)->inRandomOrder()->get()->toArray();

        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id', $session_id);

        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['session_id'=>$session_id, 'product_id'=>$id])->count();

        if ($countRecentlyViewedProducts == 0) {
            DB::table('recently_viewed_products')->insert(['session_id'=>$session_id, 'product_id'=>$id]);
        }

        //  Get Recently viewed Products Ids
        $recentViewedProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id', '!=', $id)->where('session_id', $session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        // dd($recentViewedProductsIds);

        //  Get Recently Viewed Products
        $recentViewedProducts = Product::with('brand')->whereIn('id', $recentViewedProductsIds)->get()->toArray();
        // dd($recentViewedProducts);

        //  Get Group Products (Product Code)
        $groupProducts = array();
        if (!empty($productDetails['group_code'])) {
            $groupProducts = Product::select('id', 'product_image')->where('id', '!=', $id)->where(['group_code'=> $productDetails['group_code'], 'status' => 1])->get()->toArray();
        }
        // dd($groupProducts);

        return view('front.products.detail')->with(compact('productDetails', 'categoryDetails', 'totalStock', 'similarProducts', 'recentViewedProducts', 'groupProducts'));
    }
    //  Get Product Price
    public function getProductPrice(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);
            return $getDiscountAttributePrice;
        }
    }

    //  Vendor product listing
    public function vendorListingProduct($vendor_id){
        $getVendorShop = Vendor::getVendorShopName($vendor_id);
        $vendorProducts = Product::with('brand')->where(['vendor_id'=> $vendor_id, 'status'=>1]);
        $vendorProducts = $vendorProducts->paginate(30);
        // dd($vendorProducts);
        return view('front.products.vendor_listing')->with(compact('getVendorShop', 'vendorProducts'));
    }

    //  Cart Add
    public function cartAdd(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo '<pre>'; print_r($data) ; die;

            // Check Product Stock is available or not
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'], $data['size']);
            if ($getProductStock < $data['quantity']) {                
                return redirect()->back()->with('error_message', 'Required Quantity is not available');
            }            

            //  Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }            

            //  Check product if already exists in the User Cart
            if (Auth::check()) {
                //  User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id' => $user_id])->count();
                if ($isExistsCartProduct > 0) {
                    return redirect()->back()->with('error_message', 'This product is already exists in Cart!  ');
                }
            }
            else{
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id' => $session_id])->count();
                // echo '<pre>'; print_r($countProducts) ; die;
                if ($countProducts > 0) {
                    return redirect()->back()->with('error_message', 'This product is already exists in Cart!  ');
                }
            }            

            //  Save Cart 
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            return redirect()->back()->with('success_message', 'Product has been added in Cart!  ');

        }
    }

    //  Cart page view
    public function cart(){
        $getCartItems = Cart::getCartItems();
        // echo '<pre>'; print_r($getCartItems) ; die;
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    //  Cart Update Item Qty
    public function cartUpdate(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data) ; die;

            //  Get Cart Details 
            $cartDetails = Cart::find($data['cartid']);
            // echo '<pre>'; print_r($cartDetails) ; die;

            //  Get Cart Items 
            // $getCartItems = Cart::getCartItems();

            //  Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where('product_id', $cartDetails['product_id'])->where('size', $cartDetails['size'])->first();

            //  Check Product Stock grater than Request Quantity
            if ($data['qty'] > $availableStock['stock']) {
                //  Get Cart Items 
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Stock is not Available',
                    'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                ]);
            }

            //  Check if Product Size is Available
            $availableSize = ProductsAttribute::where('product_id', $cartDetails['product_id'])->where('size', $cartDetails['size'])->where('status', 1)->count();

            if ($availableSize == 0) {
                //  Get Cart Items 
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status' => false,
                    'message' => 'Product Size is not Available. Please remove this Product and choose another one!',
                    'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                ]);
            }

            //  Update the Cart Quantity
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);            
            // echo '<pre>'; print_r($availableStock) ; die;
            //  Get Cart Items 
            $getCartItems = Cart::getCartItems();
            return response()->json([
                'status'=> true, 
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    //  Cart Delete
    public function cartDelete(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo '<pre>'; print_r($data) ; die;
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            return response()->json([
                'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
            ]);
        }
    }

}
