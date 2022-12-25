<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    // View Categories
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with('section','parentCategory')->get()->toArray();
        // echo "<pre>"; print_r($categories);
        // exit();
        return view('admin.categories.categories')->with(compact('categories'));
    }

    //  Update Category Status
    public function updateCategoryStatus(Request $request){
        $status = $request['status'];
        $category_id = $request['category_id'];
        // return $category_id;
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
            Category::where('id', $category_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'category_id'=>$category_id]);
        }        
    }

    //  Delete Category
    public function deleteCategory($id){
        // return $id;                
        Category::where('id', $id)->delete();
        @unlink('front/images/category_images/'.$id);
        $messege = "Category Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    } 

    //  Delete Delete Category Image
    public function deleteCategoryImage($id){
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
        $category_image_path = 'front/images/category_images/';
        if (file_exists($category_image_path.$categoryImage->category_image)) {
            $link = $category_image_path.$categoryImage->category_image;
            @unlink($link);
        }             
        Category::where('id', $id)->update(['category_image'=>'']);        
        $messege = "Category image has been  deleted successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }  

    // Add Edit Section 
    public function addEditCategory(Request $request, $id=null){
        Session::put('page','categories');
        if ($id=="") {
            $title = "Add Category";
            $category = new Category;
            $getCategories = Array();
            $messege = "Category Added Successfully!";
        }
        else{
            $title = "Edit Category";
            $category = Category::find($id);
            // dd($category);
            $getCategories = Category::with('subCategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get()->toArray();
            // echo "<pre>"; print_r($getCategories);
            // exit();
            $messege = "Category Updated Successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            // echo "<pre>"; print_r($data);
            // exit();
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'parent_id' => 'required',
                'url' => 'required',
            ];
            $coustomMessages = [
                'category_name.required' => 'Category name field is required',
                'category_name.regex' => 'Valid Name is required',
                'section_id.required' => 'Select section field is required',
                'parent_id.required' => 'Select category field Lavel is required',
                'url.required' => 'Category url field is required',
            ];
            $this->validate($request, $rules, $coustomMessages);  
             //  Upload Admin Photo
             if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    //  Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //  Generate New Image Name
                    $imageName = rand(11111111, 99999999) . '.' . $extension;
                    //  Generate Location
                    $imagePath = 'front/images/category_images/' . $imageName;
                    @unlink('front/images/category_images/'.$data['current_image']);
                    Image::make($image_tmp)->save($imagePath);
                    $imageName = $imageName;
                }
            } else if (!empty($data['current_image'])) {
                $imageName = $data['current_image'];
            } else {
                $imageName = '';
            }               
            $category->category_name = $data['category_name'];
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->category_image = $imageName;
            $category->save();
            return redirect('admin/categories')->with('success_message', $messege);
        }

        $getSections = Section::where('status',1)->get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'messege', 'getSections', 'getCategories'));
    }

    //  Append Categories Level By Ajax
    public function appendCategoriesLevel(Request $request){       
        if ($request->ajax()) {
            $data = $request->all();
            // return response()->json($data);
            $getCategories = Category::with('subCategories')->where(['parent_id'=>0, 'section_id'=>$data['section_id']])->get()->toArray();
            // echo "<pre>"; print_r($getCategories);
            // exit();
            return view('admin.categories.append_categories_lavel')->with(compact('getCategories'));
        }
    }

}
