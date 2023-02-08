<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class UserController extends Controller
{
    //  all
    public function users(){
        Session::put('page', 'users');
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.users')->with(compact('users'));
    }

    //  Update User Status
    public function updateUserStatus(Request $request){
        $status = $request['status'];
        $user_id = $request['user_id'];
        // return $user_id;
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
            User::where('id', $user_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'user_id'=>$user_id]);
        }        
    }
}
