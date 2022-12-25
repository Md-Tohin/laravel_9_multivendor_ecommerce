<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\Vendor;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    //  Login Register
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    //  Vendor Register
    public function vendorRegister(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'name' => 'required',                
                'mobile' => 'required|min:11|numeric|unique:admins|unique:vendors',
                'email' => 'required|email|unique:admins|unique:vendors',
                'accept' => 'required',
            ];
            $customMessages = [
                'name.required' => 'Name is required',                
                'mobile.required' => 'Mobile is required',
                'mobile.unique' => 'Mobile already exists',
                'mobile.min' => 'Mobile number at least 11 numbers',
                'mobile.numeric' => 'Valid mobile number',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',
                'accept.required' => "Please accept T & C"
            ];
            $validator = Validator::make($data, $rules, $customMessages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::beginTransaction();
            //  Create Vendor Account

            //  Insert the Vendor Details in vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;

            //  Set Default TimeZone to Bangladesh
            date_default_timezone_set("Asia/Dhaka");
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            //  Insert the Vendor Details in admins table
            $vendor_id = DB::getPdo()->lastInsertId();
            // echo "<pre>"; print_r($password); die;  

            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = Hash::make($data['password']);
            $admin->status = 0;

            //  Set Default TimeZone to Bangladesh
            date_default_timezone_set("Asia/Dhaka");
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            //  Send Confirmation Mail
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email']),
            ];

            Mail::send('emails.vendor_confirmation', $messageData, function($message)use($email) {
                $message->to($email)->subject ('Confirm Your Vendor Account');
             });

            DB::commit();           

            $message = "Thanks for registering as Vendor. Please check and confirm your email to active  your account.";
            return redirect()->back()->with('success_message', $message);

        }
    }

    //  
    public function confirmVendor($code){
        $email = base64_decode($code);
        $vendorCount = Vendor::where('email',$email)->count();
        if ($vendorCount > 0) {
            $vendorDetails = Vendor::where('email',$email)->first();
            if ($vendorDetails->confirm == 'Yes') {
                $message = "Your vendor account is already confirmed. Now You can login.";
                return redirect('vendor/login-register')->with('error_message', $message);
            } else {
                Admin::where('email', $email)->update(['confirm'=> 'Yes']);
                Vendor::where('email', $email)->update(['confirm'=> 'Yes']);

                $messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile,
                ];
                Mail::send('emails.vendor_confirmed', $messageData, function($message)use($email) {
                    $message->to($email)->subject ('Your Vendor Account Confirmed');
                });

                $message = "Your Vendor Email account is confirmed. You can login and add your personal, business and bank details to active your Vendor Account to add products";
                return redirect('vendor/login-register')->with('success_message', $message);
            }            
        }
        else{
            abort(404);
        }
    }
}
