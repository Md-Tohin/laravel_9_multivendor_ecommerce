<?php

namespace App\Http\Controllers\Front;

use DB;

use Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\OrdersProduct;
use App\Models\ProductsFilter;
use App\Models\DeliveryAddress;
use App\Models\ProductsAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

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
                $productIds = array();
                if (isset($data['price']) && !empty($data['price'])) {
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode('-', $price);   
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0],$priceArr[1]])->pluck('id')->toArray();   
                        }   
                    }
                    // echo "<pre>"; print_r($productIds); die;
                    $productIds = array_unique(array_flatten($productIds));
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
                // if ($isExistsCartProduct > 0) {
                //     return redirect()->back()->with('error_message', 'This product is already exists in Cart!  ');
                // }
            }
            else{
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id' => $session_id])->count();
                // echo '<pre>'; print_r($countProducts) ; die;                
            }            
            if ($countProducts > 0) {
                return redirect()->back()->with('error_message', 'This product is already exists in Cart!  ');
            }
            //  Save Cart 
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            Session::forget('couponAmount');
            Session::forget('couponCode');
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
                    'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
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
                    'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            //  Update the Cart Quantity
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);            
            // echo '<pre>'; print_r($availableStock) ; die;
            //  Get Cart Items 
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=> true, 
                'totalCartItems' => $totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    //  Cart Delete
    public function cartDelete(Request $request){
        if ($request->ajax()) {
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $data = $request->all();
            // echo '<pre>'; print_r($data) ; die;
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems' => $totalCartItems,
                'view' => (String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    //  Apply Coupon
    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // dd($data);
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            $couponCount = Coupon::where('coupon_code', $data['coupon'])->count();            
            if($couponCount == 0){               
                return response()->json([
                    'status'=> false, 
                    'message'=> 'The coupon is not valid', 
                    'totalCartItems' => $totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }else{
                // echo "Check for other coupon conditions";

                //  get coupon details
                $couponDetails = Coupon::where('coupon_code', $data['coupon'])->first();
                //  check if coupon is active
                if($couponDetails->status == 0){
                    $message = "The coupon is not active!";
                }    
                //  check if coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = "The coupon is expired!";
                }
                //  Check if coupon is for single time
                if ($couponDetails->coupon_type == 'Single Time') {
                    //  Check in orders table if coupon already availed by th user
                    $couponCount = Order::where(['coupon_code' => $data['coupon'], 'user_id' => Auth::user()->id])->count();;
                    if ($couponCount >= 1) {
                        $message = "This coupon code is already availed by you!";
                    }
                }
                //  check if coupon is from selected categories
                $catArr = explode(',', $couponDetails->categories);
                //  check all selected categories from coupon and convert to array
                $total_amount = 0;
                foreach($getCartItems as $key => $item){
                    if(!in_array($item['product']['category_id'], $catArr)){
                        $message = "The coupon code is not for one of the selected products.";
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                    
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                    // echo "<pre>"; print_r($attrPrice); die;                    
                }

                //  check if coupon is from selected users
                if(isset($couponDetails->users) && !empty($couponDetails->users)){
                    $userArr = explode(',', $couponDetails->users);
                    //  get user id's of all selected users
                    if(count($userArr)){
                        foreach($userArr as $user){
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }
                        //  check if any cart item not belong to coupon user
                        foreach($getCartItems as $key => $item){
                            if(!in_array($item['user_id'], $usersId)){
                                $message = "This coupon code is not for you. Try with valid coupon code!";
                            }                        
                        }
                    }                    
                }

                //  check if coupon belongs to vendor products
                if($couponDetails['vendor_id'] > 0){
                    $productIds = Product::select('id')->where('vendor_id', $couponDetails['vendor_id'])->pluck('id')->toArray();
                    // echo "<pre>"; print_r($getCartItems); die();
                    foreach($getCartItems as $item){
                        if(!in_array($item['product']['id'], $productIds)){
                            $message = "This coupon code is not for you. Try with valid coupon code!";
                        }
                    }
                }

                //  if error message is there
                if(isset($message)){
                    return response()->json([
                        'status'=> false, 
                        'message'=> $message, 
                        'totalCartItems' => $totalCartItems,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
                else{
                    //  coupon code is correct
                    //  check if coupon amount type is fixed or percentage
                    if($couponDetails->amount_type == "Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }
                    //  Add Coupon code & Amount in session variables
                    $grandTotal = $total_amount - $couponAmount;
                    $message = "Coupon Code successfully applied. You are availing discount!";
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['coupon']);
                    return response()->json([
                        'status'=> true, 
                        'message'=> $message, 
                        'couponAmount' => $couponAmount,
                        'grandTotal' => $grandTotal,
                        'totalCartItems' => $totalCartItems,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerView'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
            }
        }
        
    }

    //  Checkout 
    public function checkout(Request $request){
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $countries = Country::where('status', 1)->get();
        $getCartItems = getCartItems();
        // dd($getCartItems);
        if(count($getCartItems) == 0){
            return redirect('cart')->with('error_message', 'Shopping cart is empty! Please add products to checkout first!');
        }
        if($request->isMethod('post')){
            $data = $request->all();      
            // dd($data);    
            // Delivery Address validation
            if(empty($data['address_id'])){
                $message = "Please Select Delivery Address";
                return redirect()->back()->with('error_message', $message);
            }   
            // Payment Method validation
            if(empty($data['payment_gateway'])){
                $message = "Please Select Payment Method";
                return redirect()->back()->with('error_message', $message);
            }
            // Agree to T&C validation
            if(empty($data['accept'])){
                $message = "Please agree to terms & conditions";
                return redirect()->back()->with('error_message', $message);
            }
            //  Get Delivery Address from address_id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
            //  Set payment method as COD if COD is selected from user otherwise ser as Prepaid
            if($data['payment_gateway'] == 'COD'){
                $payment_method = 'COD';
                $order_status = 'New';
            }else{
                $payment_method = 'Prepaid';
                $order_status = 'Pending';
            }   
            DB::beginTransaction();
            $total_price = 0;
            foreach($getCartItems as $item){
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],
                $item['size']);
                $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
            }
            //  Calculate Shipping Charges
            $shipping_charges = 0;
            $grand_total = $total_price - Session::get('couponAmount');                    
            Session::put('grand_total', $grand_total);
            //  Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = $grand_total;
            $order->save();
            $order_id = DB::getPdo()->lastInsertId();

            foreach($getCartItems as $item){
                $getProductDetails = Product::select('product_code', 'product_name', 'product_color', 'vendor_id', 'admin_id')->where('id', $item['product_id'])->first()->toArray();
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $cartItem->vendor_id = $getProductDetails['vendor_id'];
                $cartItem->admin_id = $getProductDetails['admin_id'];
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],
                $item['size']);
                $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }
            Session::put('order_id', $order_id);
            DB::commit();
            //  Send order email and sms
            $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
            if ($orderDetails['payment_gateway'] == 'COD') {
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails,
                ];
                Mail::send('emails.order', $messageData, function($message)use($email){
                    $message->to($email)->subject('Order Placed - ShopMama E-commerce');
                });
            } else {
                echo "Prepaid payment methods coming soon";
            }
            
            return redirect('thanks');
        }        
        return view('front.products.checkout')->with(compact('deliveryAddresses', 'countries', 'getCartItems'));
    }

    //  Thanks
    public function thanks(){
        if (Session::has('order_id')) {
            //  Empty the Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        } else {
            return redirect('cart');
        }
        
        
    }

}
