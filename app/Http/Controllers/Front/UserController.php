<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use App\Models\Cart;
use Illuminate\Support\Str;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //  user login registration form
    public function loginRegister(){
        return view('front.users.login_register');
    }

    //  user registration
    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            $validator = Validator::make($request->all(),[
                'name' =>'required|string|max:100',
                'mobile' =>'required|numeric|digits:11',
                'email' =>'required|email|max:150|unique:users',
                'password' =>'required|min:6',
                'accept' =>'required',
            ],[
                'accept.required' => 'Please accept our Terms & Conditions'
            ]);

            if($validator->passes()){
                //  Register the User
                $user = new User();
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                //  Active the user only when user confirms hs email account
                $email = $data['email'];
                $messageData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'code' => base64_encode($data['email']),
                ];
                Mail::send('emails.confirmation', $messageData, function($message)use($email){
                    $message->to($email)->subject('Confirm your Shopmama E-Commerce Account');
                });

                $redirectTo = url('user/login-register');
                return response()->json(['type' => 'success', 'url' => $redirectTo, 'message' => 'Please confirm your email to activate your account!']);

                //  Active the user straight way without sending any confirmation email

                //  Send Register Email
                // $email = $data['email'];
                // $messageData = [
                //     'name' => $data['name'],
                //     'mobile' => $data['mobile'],
                //     'email' => $data['email'],
                // ];
                // Mail::send('emails.register', $messageData, function($message)use($email){
                //     $message->to($email)->subject('Welcome to SHOPMAMA E-Commerce');
                // });

                // if (Auth::attempt(['email'=>$data['email'], 'password'=> $data['password']])) {
                //     //  update user cart with user id
                //     if(!empty(Session::get('session_id'))){
                //         $session_id = Session::get('session_id');
                //         $user_id = Auth::user()->id;
                //         Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                //     }
                //     $redirectTo = url('cart');
                //     return response()->json(['type'=>'success', 'url'=>$redirectTo]);
                // }
            }
            else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }            
        }
    } 

    //  Forgot Password
    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;

            $validator = Validator::make($request->all(),[                
                'email' =>'required|email|max:150|exists:users',                
            ],[
                'email.exists' => 'Email does not exists!',
            ]);

            if($validator->passes()){                
                $email = $data['email'];
                //  Generate new password
                $new_password = Str::random(12);
                User::where('email', $email)->update(['password'=>bcrypt($new_password)]);
                //  Get User Details
                $userDetails = User::where('email', $email)->first()->toArray();
                //  Send User to Email
                $messageData = [
                    'name' => $userDetails['name'],
                    'email' => $email,
                    'password' => $new_password,
                ];
                Mail::send('emails.user_forgot_password', $messageData, function($message)use($email){
                    $message->to($email)->subject('New Password - Shopmama E-commerce');
                });

                $redirectTo = url('user/login-register');
                return response()->json(['type' => 'success', 'url' => $redirectTo, 'message' => 'New Password sent to your register email.']);
            }
            else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.forgot_password');
        }
    }

    //  User Login
    public function userLogin(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre></pre>"; print_r($data); die();
            $validator = Validator::make($request->all(),[                
                'email' =>'required|email|max:150|exists:users',
                'password' =>'required|min:6',
            ]);

            if($validator->passes()){
                if (Auth::attempt(['email'=>$data['email'], 'password'=> $data['password']])) {
                    if(Auth::user()->status == 0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive', 'message'=> 'Your account is not activated! Please confirm your account to activate your account.']);
                    }
                    //  update user cart with user id
                    if(!empty(Session::get('session_id'))){
                        $session_id = Session::get('session_id');
                        $user_id = Auth::user()->id;
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success', 'url'=>$redirectTo]);
                }else {
                    return response()->json(['type'=>'incorrect', 'message'=> 'Incorrect email or password!']);
                }
            }
            else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }
    }

    //  User Logout
    public function userLogout(){
        Auth::logout();
        return redirect('/user/login-register');
    }

    //  Confirm Account
    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if($userCount > 0){
            $userDetails = User::where('email', $email)->first();
            if($userDetails->status == 1){
                return redirect('/user/login-register')->with('error_message', 'Your account is already activated. You can login now.');
            }
            else{
                User::where('email', $email)->update(['status'=>1]);
                //  Send welcome email
                $messageData = [
                    'name' => $userDetails->name,
                    'mobile' => $userDetails->mobile,
                    'email' => $email,
                ];
                Mail::send('emails.register', $messageData, function($message)use($email){
                    $message->to($email)->subject('Welcome to SHOPMAMA E-Commerce');
                });

                //  Redirect the user to Login/Register page with  success message
                return redirect('user/login-register')->with('success_message', 'Your account is activated. Your can login now.');
            }
        }
        else{
            abort(404);
        }
    }

    //  User Update Details
    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'name' =>'required|string|max:100',
                'mobile' =>'required|numeric|digits:11',
                'address' =>'required|string|max:200',
                'city' =>'required|string|max:100',
                'state' =>'required|string|max:100',
                'country' =>'required|string|max:100',
                'pincode' =>'required',
            ]);
            if($validator->passes()){
                User::where('id', Auth::user()->id)->update([
                    'name' => $data['name'],
                    'mobile' => $data['mobile'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'pincode' => $data['pincode'],
                ]);
                return response()->json(['type' => 'success', 'message' => 'Your account/billing details successfully updated!']);
            }
            else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }else {
            $countries = Country::where('status', 1)->get();
            return view('front.users.user_account')->with(compact('countries'));
        }
    }

    //  User Update Password
    public function updatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'current_password' =>'required',
                'new_password' =>'required|min:8',
                'confirm_password' =>'required|min:8|same:new_password',
            ]);
            if($validator->passes()){
                $current_password = $data['current_password'];
                $checkPassword = User::where('id', Auth::user()->id)->first();
                if(Hash::check($current_password, $checkPassword->password)){
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);  
                    $user->save();
                    return response()->json(['type' => 'success', 'message' => 'Account password successfully updated!']);
                }   
                else{
                    return response()->json(['type' => 'incorrect', 'message' => 'Your current password is incorrect!']);
                }
            }
            else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }
    }

}
