<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Image;

class BannerController extends Controller
{
    //  banners
    public function banners(){
        Session::put('page','sliders');
        $banners = Banner::get()->toArray();
        // echo "<pre>"; print_r($banners);
        return view('admin.banners.banners')->with(compact('banners'));
    }

    //  Delete Banner
    public function deleteBanner($id){
        // return $id;   
        $banner_image = Banner::where('id', $id)->first();
        $banner_image_path = 'front/images/banner_images/';
        // return $banner_path;
        if (file_exists($banner_image_path.$banner_image->image)) {
            if (!($banner_image->image == 'no_image.jpg')) {
                unlink($banner_image_path.$banner_image->image);
            }            
        }
        Banner::find($id)->delete();
        $messege = "Banner Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }   

    //  Delete Delete Product Image
    public function deleteBannerImage($id){
        // return $id;
        $banner_image = Banner::where('id', $id)->first();
        $banner_image_path = 'front/images/banner_images/';
        // return $banner_path;
        if (file_exists($banner_image_path.$banner_image->image)) {
            if (!($banner_image->image == 'no_image.jpg')) {
                unlink($banner_image_path.$banner_image->image);
            }            
        }
        Banner::where('id',$id)->update(['image'=>'']);
        $messege = "Banner Image Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }

    //  Update Banner Status
    public function updateBannerStatus(Request $request){
        $status = $request['status'];
        $banner_id = $request['banner_id'];
        // return $banner_id;
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
            Banner::where('id', $banner_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'banner_id'=>$banner_id]);
        }        
    }

    // Add Edit Banner 
    public function addEditBanner(Request $request, $id=null){
        Session::put('page', 'sliders');
        if ($id=="") {
            $title = "Add Banner Image";
            $banner = new Banner;
            $messege = "Banner Added Successfully!";
        }
        else{
            $title = "Edit Banner Image";
            $banner = Banner::find($id);
            $messege = "Banner Updated Successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);
            // exit();
            $rules = [
                'type' => 'required',
                'title' => 'required',
                'alt' => 'required',
                'link' => 'required',
            ];
            $coustomMessages = [
                'type.required' => 'Banner Type Field is required',
                'title.required' => 'Banner Title Field is required',
                'alt.required' => 'Banner Alternative Field is required',
                'link.required' => 'Banner Link Field is required',
            ];
            $this->validate($request, $rules, $coustomMessages);    

            if ($data['type'] == 'Slider') {
                $width = "1920";
                $height = "720";
            } else {
                $width = "1920";
                $height = "450";
            }
            
            //  Upload Banner Image
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //  Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //  Generate New Image Name
                    $imageName = rand(11111111, 99999999) . '.' . $extension;
                    //  Generate Location
                    $imagePath = 'front/images/banner_images/' . $imageName;
                    @unlink('front/images/banner_images/'.$imageName);
                    Image::make($image_tmp)->resize($width,$height)->save($imagePath);     
                    $imageName = $imageName;               
                }
            } 
            elseif (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } 
            else{
                $imageName = "";
            }  
            $banner->image = $imageName;
            $banner->type = $data['type'];
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->alt = $data['alt'];
            $banner->save();   
            return redirect('admin/banners')->with('success_message', $messege);          
        }       
           

        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner', 'messege'));
    }
}
