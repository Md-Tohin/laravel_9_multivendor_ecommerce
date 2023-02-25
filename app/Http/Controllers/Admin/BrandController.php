<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Session;
use Image;
use Carbon;

class BrandController extends Controller
{
    //  View
    public function brands(){
        Session::put('page', 'brands');
        $brands = Brand::orderBy('id', 'desc')->get()->toArray();
        // echo "<pre>"; print_r($brands);
        return view('admin.brands.brands')->with(compact('brands'));
    }

    //  Delete Brand
    public function deleteBrand($id){
        // return $id;        
        Brand::where('id', $id)->delete();
        $messege = "Brand Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }   

    //  Update Brand Status
    public function updateBrandStatus(Request $request){
        $status = $request['status'];
        $brand_id = $request['brand_id'];
        // return $brand_id;
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
            Brand::where('id', $brand_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'brand_id'=>$brand_id]);
        }        
    }

    // Add Edit Brand 
    public function addEditBrand(Request $request, $id=null){
        Session::put('page', 'brands');
        if ($id=="") {
            $title = "Add Brand";
            $brand = new Brand;
            $messege = "Brand Added Successfully!";
        }
        else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $messege = "Brand Updated Successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);
            // exit();
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $coustomMessages = [
                'name.required' => 'Brand name is required',
                'name.regex' => 'Valid Name is required',
            ];
            $this->validate($request, $rules, $coustomMessages);                 
            $brand->name = $data['name'];
            $brand->save();
            return redirect('admin/brands')->with('success_message', $messege);
        }

        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand', 'messege'));
    }
}
