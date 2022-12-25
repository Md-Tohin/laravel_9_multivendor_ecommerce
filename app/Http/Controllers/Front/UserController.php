<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;

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
            ]);

            if($validator->passes()){
                //  Register the User
                $user = new User();
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();

                //  Send Register Email
                $email = $data['email'];
                $messageData = [
                    'name' => $data['name'],
                    'mobile' => $data['mobile'],
                    'email' => $data['email'],
                ];
                Mail::send('emails.register', $messageData, function($message)use($email){
                    $message->to($email)->subject('Welcome to SHOPMAMA E-Commerce');
                });

                if (Auth::attempt(['email'=>$data['email'], 'password'=> $data['password']])) {
                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success', 'url'=>$redirectTo]);
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
}
