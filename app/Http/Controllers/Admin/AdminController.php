<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\VendorsBusinessDetails;
use App\Models\VendorsBankDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Session;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // login
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $coustomMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $coustomMessages);
            // if (
            //     Auth::guard('admin')->attempt([
            //         'email' => $data['email'],
            //         'password' => $data['password'],
            //         'status' => 1,
            //     ])
            // ) {
            //     return redirect('admin/dashboard');
            // } else {
            //     return redirect()
            //         ->back()
            //         ->with('error_message', 'Invalid Email or Password');
            // }

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']]) ) {
                if(Auth::guard('admin')->user()->type == "vendor" && Auth::guard('admin')->user()->confirm == "No"){
                    return redirect()->back()->with('error_message', 'You confirm your email to activate your vendor Account');
                } 
                else if(Auth::guard('admin')->user()->type == "vendor" && Auth::guard('admin')->user()->status == "0"){
                    return redirect()->back()->with('error_message', 'Your admin account is not active');
                }
                else{
                    return redirect('admin/dashboard');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error_message', 'Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    // Dashboard
    public function dashboard()
    {
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    //  Update Admin Password
    public function updateAdminPassword(Request $request)
    {
        Session::put('page','update_admin_password');
        if ($request->isMethod('post')) {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required',
            ];
            $coustomMessages = [
                'current_password.required' => 'Current password is required',
                'new_password.required' => 'New password is required',
                'new_password.min' => 'New password minimum lenght 8',
                'confirm_password.required' => 'Confirm Password is required',
            ];
            $this->validate($request, $rules, $coustomMessages);
            $data = $request->all();
            // dd($data);
            if (
                Hash::check(
                    $data['current_password'],
                    Auth::guard('admin')->user()->password
                )
            ) {
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where(
                        'id',
                        Auth::guard('admin')->user()->id
                    )->update([
                        'password' => bcrypt($data['new_password']),
                        'updated_at' => Carbon::now(),
                    ]);
                    return redirect()
                        ->back()
                        ->with(
                            'success_message',
                            'Password has been updated successfully!'
                        );
                } else {
                    return redirect()
                        ->back()
                        ->with(
                            'error_message',
                            'New Password & Confirm Password does not Match!'
                        );
                }
            } else {
                return redirect()
                    ->back()
                    ->with(
                        'error_message',
                        'Your Current Password is Incorrect!'
                    );
            }
        }
        $adminDetails = Admin::where(
            'email',
            Auth::guard('admin')->user()->email
        )
            ->first()
            ->toArray();
        return view('admin.settings.update-admin-password')->with(
            compact('adminDetails')
        );
    }

    //  Check Admin Password
    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if (
            Hash::check(
                $data['current_password'],
                Auth::guard('admin')->user()->password
            )
        ) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //  Update Admin Details
    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update_admin_details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];
            $coustomMessages = [
                'name.required' => 'Name is required',
                'name.regex' => 'Valid Name is required',
                'mobile.required' => 'Mobile is required ',
                'mobile.numeric' => 'Valid Mobile is required',
            ];
            $this->validate($request, $rules, $coustomMessages);

            //  Upload Admin Photo
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //  Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //  Generate New Image Name
                    $imageName = rand(11111111, 99999999) . '.' . $extension;
                    //  Generate Location
                    $imagePath = 'admin/images/photos/' . $imageName;
                    @unlink(
                        'admin/images/photos/' .
                            Auth::guard('admin')->user()->image
                    );
                    Image::make($image_tmp)->save($imagePath);
                }
            } elseif (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = '';
            }
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'image' => $imageName,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()
                ->back()
                ->with(
                    'success_message',
                    'Admin Details updated successfully!'
                );
        }
        $adminDetails = Admin::where(
            'email',
            Auth::guard('admin')->user()->email
        )
            ->first()
            ->toArray();
        return view('admin.settings.update-admin-details')->with(
            compact('adminDetails')
        );
    }

    //  Update Vendor Details
    public function updateVendorDetails($slug, Request $request)
    {
        if ($slug == 'personal') {
            Session::put('page', 'vendor_personal');
            if ($request->isMethod('post')) {
                $data = $request->all();
                // echo '<pre>'; print_r($data); die;
                $rules = [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',
                    'pincode' => 'required',
                    'mobile' => 'required|numeric',
                ];
                $coustomMessages = [
                    'name.required' => 'Name is required',
                    'name.regex' => 'Valid Name is required',
                    'address.required' => 'Address is required ',
                    'city.required' => 'City is required ',
                    'state.required' => 'State is required ',
                    'country.required' => 'Country is required ',
                    'pincode.required' => 'Pincode is required ',
                    'mobile.numeric' => 'Valid Mobile is required',
                ];
                $this->validate($request, $rules, $coustomMessages);
                //  Upload Vendor Photo
                if ($request->hasFile('image')) {
                    $image_tmp = $request->file('image');
                    if ($image_tmp->isValid()) {
                        //  Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //  Generate New Image Name
                        $imageName =
                            rand(11111111, 99999999) . '.' . $extension;
                        //  Generate Location
                        $imagePath = 'admin/images/photos/' . $imageName;
                        @unlink(
                            'admin/images/photos/' .
                                Auth::guard('admin')->user()->image
                        );
                        Image::make($image_tmp)->save($imagePath);
                    }
                } elseif (!empty($data['current_image'])) {
                    $imageName = $data['current_image'];
                } else {
                    $imageName = '';
                }
                //  Update Admin Table
                Admin::where('id', Auth::guard('admin')->user()->id)->update([
                    'name' => $data['name'],
                    'mobile' => $data['mobile'],
                    'image' => $imageName,
                    'updated_at' => Carbon::now(),
                ]);
                //  Update Vendor Table
                Vendor::where(
                    'id',
                    Auth::guard('admin')->user()->vendor_id
                )->update([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'pincode' => $data['pincode'],
                    'mobile' => $data['mobile'],
                    'updated_at' => Carbon::now(),
                ]);
                return redirect()
                    ->back()
                    ->with(
                        'success_message',
                        'Vendor Details updated successfully!'
                    );
            }
            $vendorDetails = Vendor::where(
                'id',
                Auth::guard('admin')->user()->vendor_id
            )
                ->first()
                ->toArray();
            // echo '<pre>'; print_r($vendorDetails); die;
        } elseif ($slug == 'business') {
            Session::put('page', 'vendor_business');
            if ($request->isMethod('post')) {
                $data = $request->all();
                // echo '<pre>'; print_r($data); die;
                $rules = [
                    'shop_name' => 'required',
                    'shop_address' => 'required',
                    'shop_city' => 'required',
                    'shop_state' => 'required',
                    'shop_country' => 'required',
                    'shop_pincode' => 'required',
                    'shop_mobile' => 'required|numeric',
                    'shop_email' => 'required',
                    'shop_website' => 'required',
                    'business_license_number' => 'required',
                    'gst_number' => 'required',
                    'pan_number' => 'required',
                    'address_proof' => 'required',
                ];
                $coustomMessages = [
                    'shop_name.required' => 'shop_name is required',
                    'shop_address.required' => 'shop_address is required ',
                    'shop_city.required' => 'shop_city is required ',
                    'shop_state.required' => 'shop_state is required ',
                    'shop_country.required' => 'shop_country is required ',
                    'shop_pincode.required' => 'shop_pincode is required ',
                    'shop_mobile.required' => 'shop_mobile is required ',
                    'shop_email.numeric' => 'shop_email is required',
                    'shop_website.required' => 'shop_website is required ',
                    'business_license_number.required' =>
                        'business_license_number is required ',
                    'gst_number.required' => 'gst_number is required ',
                    'pan_number.required' => 'pan_number is required ',
                    'address_proof.required' => 'address_proof is required ',
                ];
                $this->validate($request, $rules, $coustomMessages);
                //  Upload Vendor Photo
                if ($request->hasFile('address_proof_image')) {
                    $image_tmp = $request->file('address_proof_image');
                    if ($image_tmp->isValid()) {
                        //  Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //  Generate New Image Name
                        $imageName =
                            rand(11111111, 99999999) . '.' . $extension;
                        //  Generate Location
                        $imagePath = 'admin/images/proofs/' . $imageName;

                        @unlink(
                            'admin/images/proofs/' . $data['current_image']
                        );
                        Image::make($image_tmp)->save($imagePath);
                    }
                } elseif (!empty($data['current_image'])) {
                    $imageName = $data['current_image'];
                } else {
                    $imageName = '';
                }
                //  Update Vendor Table
                $vendorCount = VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id )->update([
                        'shop_name' => $data['shop_name'],
                        'shop_address' => $data['shop_address'],
                        'shop_city' => $data['shop_city'],
                        'shop_state' => $data['shop_state'],
                        'shop_country' => $data['shop_country'],
                        'shop_pincode' => $data['shop_pincode'],
                        'shop_mobile' => $data['shop_mobile'],
                        'shop_email' => $data['shop_email'],
                        'shop_website' => $data['shop_website'],
                        'business_license_number' =>
                            $data['business_license_number'],
                        'gst_number' => $data['gst_number'],
                        'pan_number' => $data['pan_number'],
                        'address_proof' => $data['address_proof'],
                        'address_proof_image' => $imageName,
                        'updated_at' => Carbon::now(),
                    ]);
                }
                else {
                    VendorsBusinessDetails::insert([
                        'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                        'shop_name' => $data['shop_name'],
                        'shop_address' => $data['shop_address'],
                        'shop_city' => $data['shop_city'],
                        'shop_state' => $data['shop_state'],
                        'shop_country' => $data['shop_country'],
                        'shop_pincode' => $data['shop_pincode'],
                        'shop_mobile' => $data['shop_mobile'],
                        'shop_email' => $data['shop_email'],
                        'shop_website' => $data['shop_website'],
                        'business_license_number' =>
                            $data['business_license_number'],
                        'gst_number' => $data['gst_number'],
                        'pan_number' => $data['pan_number'],
                        'address_proof' => $data['address_proof'],
                        'address_proof_image' => $imageName,
                        'created_at' => Carbon::now(),
                    ]);
                }
                
                return redirect()
                    ->back()
                    ->with(
                        'success_message',
                        'Vendor Details updated successfully!'
                    );
            }
            $vendorCount = VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBusinessDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }
            else {
                $vendorDetails = array();
            }
            
            // echo '<pre>'; print_r($vendorDetails); die;
        } elseif ($slug == 'bank') {
            Session::put('page', 'vendor_bank');
            if ($request->isMethod('post')) {
                $data = $request->all();
                // dd($data);
                $rules = [
                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name' => 'required',
                    'bank_ifsc_code' => 'required',
                    'account_number' => 'required|numeric',
                ];
                $coustomMessages = [
                    'account_holder_name.required' => 'Name is required',
                    'account_holder_name.regex' => 'Valid Name is required',
                    'bank_name.required' => 'Bank name is required ',
                    'bank_ifsc_code.required' => 'Bank IFSC code is required ',
                    'account_number.required' => 'Account Number is required ',
                    'account_number.numeric' =>
                        'Valid Account Number is required',
                ];
                $this->validate($request, $rules, $coustomMessages);
                //  Update Bank Details
                $vendorCount = VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                        'account_holder_name' => $data['account_holder_name'],
                        'bank_name' => $data['bank_name'],
                        'account_number' => $data['account_number'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                        'updated_at' => Carbon::now(),
                    ]);
                }
                else {
                    VendorsBankDetails::insert([
                        'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                        'account_holder_name' => $data['account_holder_name'],
                        'bank_name' => $data['bank_name'],
                        'account_number' => $data['account_number'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                        'created_at' => Carbon::now(),
                    ]);
                }
                return redirect()
                    ->back()
                    ->with(
                        'success_message',
                        'Vendor Details updated successfully!'
                    );
            }
            $vendorCount = VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount > 0) {
                $vendorDetails = VendorsBankDetails::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }
            else {
                $vendorDetails = array();
            }

            // dd($vendorDetails);
        }
        $countries = Country::where('status', 1)->get();
        // dd($countries);
        return view('admin.settings.update-vendor-details')->with(
            compact('slug', 'vendorDetails', 'countries')
        );
    }

    //
    public function admins($type = null)
    {
        $admins = Admin::query();
        if (!empty($type)) {
            $admins = $admins->where('type', $type);
            $title = ucfirst($type) . 's';
            Session::put('page', strtolower($type));
        } else {
            $title = 'All Admins/Subadmins/Vendors';
            Session::put('page', 'view_all');
        }
        $admins = $admins->get()->toArray();
        // dd($admins);
        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }

    //  View Vendor Details
    public function viewVendorDetails($id)
    {
        // $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id', $id)->first();
        $vendorDetails = Admin::with('vendorPersonal')->where('id', $id)->first();
        $vendorBusinessDetails = VendorsBusinessDetails::where('vendor_id', $id)->first();
        $vendorBankDetails = VendorsBankDetails::where('vendor_id', $id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails), true);
        // dd($vendorDetails);
        return view('admin.admins.view-vendor-details')->with(compact('vendorDetails', 'vendorBusinessDetails', 'vendorBankDetails'));
    }

    //  Update Admin Status
    public function updateAdminStatus(Request $request){
        $status = $request['status'];
        $admin_id = $request['admin_id'];
        // return $admin_id;
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
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            $adminDetails = Admin::where('id', $data['admin_id'])->first()->toArray();
            // echo '<pre>'; print_r($adminDetails);
            if ($adminDetails['type'] == "vendor" && $status == 1) {
                Vendor::where('id', $adminDetails['vendor_id'])->update(['status' => $status]);
                //  Send Approval Email 
                $email = $adminDetails['email'];
                 
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                ];
                // echo '<pre>'; print_r($messageData);
                Mail::send('emails.vendor_approved', $messageData, function($message)use($email) {
                    $message->to($email)->subject ('Vendor Account ia Approved');
                });
            }
            // return "ok";
            return response()->json(['status'=>$status, 'admin_id'=>$admin_id]);
        }        
    }

    // Logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}