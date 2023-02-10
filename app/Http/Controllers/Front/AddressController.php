<?php

namespace App\Http\Controllers\front;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    //  Get Delivery Address
    public function getDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddress = DeliveryAddress::where('id', $data['addressid'])->first()->toArray();
            // echo "<pre>"; print_r($address); die;
            return response()->json(['address' => $deliveryAddress]);
        };
    }

    //  Save Delivery Address
    public function saveDeliveryAddress(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'delivery_name' => 'required|string|max:100',
                'delivery_mobile' => 'required|numeric|digits:11',
                'delivery_address' => 'required|string|max:200',
                'delivery_city' => 'required|string|max:100',
                'delivery_state' => 'required|string|max:100',
                'delivery_country' => 'required|string|max:100',
                'delivery_pincode' => 'required|numeric|digits:6',
            ]);
            if($validator->passes()){
                $data = $request->all();            
                // echo "<pre>"; print_r($data); die;
                $address = array();
                $address['user_id'] = Auth::user()->id;
                $address['name'] = $data['delivery_name'];
                $address['address'] = $data['delivery_address'];
                $address['city'] = $data['delivery_city'];
                $address['state'] = $data['delivery_state'];
                $address['country'] = $data['delivery_country'];
                $address['pincode'] = $data['delivery_pincode'];
                $address['mobile'] = $data['delivery_mobile'];    
                if(!empty($data['delivery_id'])){
                    //  Update Delivery Address
                    DeliveryAddress::where('id', $data['delivery_id'])->update($address);
                }else{
                    //  Add Delivery Address
                    DeliveryAddress::create($address);
                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses();
                $countries = Country::where('status', 1)->get();
                return response()->json([
                    'view' => (String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses', 'countries'))
                ]);
            }
            else{
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
            
        }
    }

    //  Delete Delivery Address
    public function deleteDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddress = DeliveryAddress::where('id', $data['addressid'])->delete();
            // echo "<pre>"; print_r($address); die;
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $countries = Country::where('status', 1)->get();
            return response()->json([
                'view' => (String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses', 'countries'))
            ]);
        };
    }
}
