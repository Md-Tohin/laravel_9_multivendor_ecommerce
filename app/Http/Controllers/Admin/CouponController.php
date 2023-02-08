<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Session;
use App\Models\Section;
use App\Models\User;
use App\Models\Brand;

class CouponController extends Controller
{
    //  view coupons 
    public function coupons(){
        Session::put('page','coupons');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == 'vendor') {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect('admin/update-vendor-details/personal')->with('error_message','Your Vendor Account is not approved yet. Please make sure to fil your valid personal, business and bank details');
            }
            $coupons = Coupon::orderBy('id', 'desc')->where('vendor_id', $vendor_id)->get()->toArray();
        }else{
            $coupons = Coupon::orderBy('id', 'desc')->get()->toArray();
        }        
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    //  coupon add or edit
    public function addEditCoupon(Request $request, $id = null){
        Session::put('page','coupons');
        if($id == ""){
            $title = 'Add Coupon';
            $coupon = new Coupon;
            $selCategories = array();
            $selBrands = array();
            $selUsers = array();
            $message = "Coupon added successfully!";
        }else {
            $title = 'Edit Coupon';
            $coupon = Coupon::findOrFail($id);
            $selCategories = explode(',',$coupon->categories);
            $selBrands = explode(',',$coupon->brands);
            $selUsers = explode(',',$coupon->users);
            $message = "Coupon Updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
            $rules = [
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'categories' => 'required',
                'brands' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required',
            ];
            $customMessages = [
                'coupon_option.required' => 'Select coupon option',
                'coupon_type.required' => 'Select coupon type',
                'amount_type.required' => 'Select amount type',
                'categories.required' => 'Select categories',
                'brands.required' => 'Select brands',
                'amount.required' => 'Enter amount',
                'amount.numeric' => 'Enter valid amount',
                'expiry_date.required' => 'Enter expiry date',     
            ];
            $this->validate($request, $rules, $customMessages);  

            if(isset($data['categories'])){
                $categories = implode(',', $data['categories']);
            }else{
                $categories = "";
            }
            
            if(isset($data['brands'])){
                $brands = implode(',', $data['brands']);
            }else{
                $brands = "";
            }

            if(isset($data['users'])){
                $users = implode(',', $data['users']);
            }else{
                $users = "";
            }

            if($data['coupon_option'] == "Automatic"){
                $coupon_code = str_random(8);                
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $type = Auth::guard('admin')->user()->type;
            if($type == 'vendor'){
                $vendor_id = Auth::guard('admin')->user()->vendor_id;
            }else{
                $vendor_id = 0;
            }

            $coupon->vendor_id = $vendor_id;
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->categories = $categories;
            $coupon->brands = $brands;
            $coupon->users = $users;
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();
            return redirect('admin/coupons')->with('success_message', $message);
        }

        $categories = Section::with('categories')->get()->toArray();
        $brands = Brand::where('status',1)->get();
        $users = User::where('status',1)->get();        

        return view('admin.coupons.add_edit_coupon')->with(compact('title', 'coupon', 'categories', 'brands', 'users', 'selCategories', 'selBrands', 'selUsers'));
    }

    //  Update coupon Status
    public function updateCouponStatus(Request $request){
        $status = $request['status'];
        $coupon_id = $request['coupon_id'];
        // return $coupon_id;
        // exit();
        if ($request->ajax()) {
            $data = $request->all();
            if ($status == "Active") {
                $status = 0;
                // return $status;
            } else {
                $status = 1;
                // return $status;
            }            
            Coupon::where('id', $coupon_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'coupon_id'=>$coupon_id]);
        }        
    }

    //  Delete Coupon
    public function deleteCoupon($id){
        // return $id; 
        Coupon::find($id)->delete();
        $message = "Coupon Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$message);
    }   
}
