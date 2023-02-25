<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\ProductImage;
use App\Models\ProductsFilter;
use Auth;
use Image;

class ProductController extends Controller
{ 
    // View Products
    public function products(){
        Session::put('page','products');
        $adminType = Auth::guard('admin')->user()->type;
        $vendorId = Auth::guard('admin')->user()->vendor_id;
        if ($adminType == 'vendor') {
            $vendorStatus = Auth::guard('admin')->user()->status;
            if ($vendorStatus == 0) {
                return redirect('admin/update-vendor-details/personal')->with('error_message','Your Vendor Account is not approved yet. Please make sure to fil your valid personal, business and bank details');
            }
        } 
        
        $products = Product::orderBy('id','desc')->with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        },'brand'=>function($query){
            $query->select('id','name');
        }]);
       
        if ($adminType == 'vendor') {
            $products = $products->where('vendor_id',$vendorId);
        }       
        $products = $products->get()->toArray();
        return view('admin.products.products')->with(compact('products'));
    }

    //  Update Product Status
    public function updateProductStatus(Request $request){
        Session::put('page','products');
        $status = $request['status'];
        $product_id = $request['product_id'];
        // return $product_id;
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
            Product::where('id', $product_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'product_id'=>$product_id]);
        }        
    }

    //  Delete Product
    public function deleteProduct($id){
        Session::put('page','products');
        // return $id;  
        // return $id;   
        $product_image = Product::where('id', $id)->first();
        $small_product_image_path = 'front/images/product_images/small/';
        $medium_product_image_path = 'front/images/product_images/medium/';
        $large_product_image_path = 'front/images/product_images/large/';
        // return $banner_path;
        if (!empty($product_image->product_image) && file_exists($small_product_image_path.$product_image->product_image)) {
            if (!($product_image->product_image == 'no_image.jpg')) {
                unlink($small_product_image_path.$product_image->product_image);
                unlink($medium_product_image_path.$product_image->product_image);
                unlink($large_product_image_path.$product_image->product_image);
            }            
        }
        Product::find($id)->delete();
        $messege = "Product Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    } 

    //  Delete Delete Product Image
    public function deleteProductImage($id){
        Session::put('page','products');
        $productImage = Product::select('product_image')->where('id',$id)->first();
        $small_product_image_path = 'front/images/product_images/small/'.$productImage->product_image;
        $medium_product_image_path = 'front/images/product_images/medium/'.$productImage->product_image;
        $large_product_image_path = 'front/images/product_images/large/'.$productImage->product_image;
        if (file_exists($small_product_image_path) && file_exists($medium_product_image_path) && file_exists($large_product_image_path)) {
            unlink($small_product_image_path);
            unlink($medium_product_image_path);
            unlink($large_product_image_path);
        }             
        Product::where('id', $id)->update(['product_image'=>'']);        
        $messege = "Product image has been  deleted successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }  
    //  Delete Delete Product Video
    public function deleteProductVideo($id){
        Session::put('page','products');
        $productVideo = Product::select('product_video')->where('id',$id)->first();
        $product_video = 'front/videos/product_videos/'.$productVideo->product_video.'/'.$productVideo->product_video;
        if (file_exists($product_video)) {
            @unlink($product_video);
        }             
        Product::where('id', $id)->update(['product_video'=>'']);        
        $messege = "Product video has been  deleted successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }  

    // Add Edit Product 
    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');

        if ($id=="") {
            $title = "Add Product";   
            $product = new Product;        
            $messege = "Product Added Successfully!";
        }
        else{
            $title = "Edit Product";      
            $product = Product::find($id);
            // echo "<pre>"; print_r($product);    
            // dd($product);
            $messege = "Product Updated Successfully!";
        }

        //  Validation
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            // echo "<pre>"; print_r($data);
            // exit();
            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'category_id' => 'required',
                // 'product_code' => 'required|regex:/^\w+$/',
                'product_code' => 'required',
                'product_color' => 'required',
                'product_price' => 'required|numeric',
            ];
            $coustomMessages = [
                'product_name.required' => 'Product name field is required',
                'product_name.regex' => 'Valid Name is required',
                'category_id.required' => 'Category field is required',
                'product_code.required' => 'Product code field is required',
                // 'product_code.regex' => 'Valid Product code is required',
                'product_price.required' => 'Product Price field is required',
                'product_price.numeric' => 'Valid Product Price is required',                
                'product_color.required' => 'Product Color field is required',
            ];
            $this->validate($request, $rules, $coustomMessages);  

            //  Upload Product Image After Resize Small 250 * 250 Medium 500 * 500 Large 1000 * 1000
             if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    //  Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //  Generate New Image Name
                    $imageName = rand(11111111, 99999999) . '.' . $extension;
                    //  Generate Location
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;  

                    $product_image = Product::where('id', $id)->first();
                    $small_product_image_path = 'front/images/product_images/small/';
                    $medium_product_image_path = 'front/images/product_images/medium/';
                    $large_product_image_path = 'front/images/product_images/large/';
                    // return $banner_path;
                    if (!empty($product_image->product_image) && file_exists($small_product_image_path.$product_image->product_image)) {
                        if (!($product_image->product_image == 'no_image.jpg')) {
                            unlink($small_product_image_path.$product_image->product_image);
                            unlink($medium_product_image_path.$product_image->product_image);
                            unlink($large_product_image_path.$product_image->product_image);
                        }            
                    }                
                   
                    //  Image Store
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    $imageName = $imageName;
                }
            } else if (!empty($data['current_image'])) {               
                $imageName = $data['current_image'];               
            } else {
                $imageName = '';
            } 

            //  Video Upload
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    //  Get Image Extension
                    $extension = $video_tmp->getClientOriginalExtension();
                    //  Generate New Image Name
                    $genVideoName = rand(11111111, 99999999).'.' . $extension;
                    //  Generate Location
                    $videoPath = 'front/videos/product_videos/' . $genVideoName;

                    //  Unlink When Delete or Update
                    @unlink('front/videos/product_videos/'.$data['current_video'].'/'.$data['current_video']);

                    $video_tmp->move('front/videos/product_videos/',$genVideoName);
                    $videoName = $genVideoName;
                }
            } else if (!empty($data['current_video'])) {
                $videoName = $data['current_video'];
            } else {
                $videoName = '';
            } 

            $categoryDetails = Category::find($data['category_id']);
            // dd($categories);
            $adminType = Auth::guard('admin')->user()->type;
            $vendorId = Auth::guard('admin')->user()->vendor_id;
            $adminId = Auth::guard('admin')->user()->id;

            if ($adminType=="vendor") {
                $product->vendor_id = $vendorId;
            }else{
                $product->vendor_id = 0;
            }

            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->admin_id = $adminId;
            $product->admin_type = $adminType;
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->group_code = $data['group_code'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            //  filter Values
            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $key => $filter) {
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $data['category_id']);
                if ($filterAvailable == 'Yes'){
                    // dd($data[$filter['filter_column']]);
                    if (isset($filter['filter_column']) && $data[$filter['filter_column']]) {
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }                
            }

            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }

            if (!empty($data['is_bestseller'])) {
                $product->is_bestseller = $data['is_bestseller'];
            } else {
                $product->is_bestseller = "No";
            }
            
            $product->product_image = $imageName;
            $product->product_video = $videoName;
            $product->save();
                       
            return redirect('admin/products')->with('success_message', $messege);
        }
        $categories = Section::with('categories')->get()->toArray();
        // dd($categories);
        // exit();
        $getBrands = Brand::where('status',1)->get();

        return view('admin.products.add_edit_product')->with(compact('title', 'messege', 'categories', 'product', 'getBrands'));
    }

    //  Add Edit Attributes 
    public function addEditAttributes(Request $request, $id=null){
        Session::put('page','products');
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('attributes')->find($id)->toArray();
        // echo "<pre>"; print_r($product); die;   
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;  
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    //  SKU Attribute Check
                    $skuCount = ProductsAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', 'SKU already exists! Please try another SKU!');
                    }
                    //  Size Attribute Check
                    $sizeCount = ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', 'Size already exists! Please try another Size!');
                    }
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message', 'Product Attributes has been added Successfully!');
        }     
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

     //  Update Attribute Status
     public function updateAttributeStatus(Request $request){
        Session::put('page','products');
        $status = $request['status'];
        $attribute_id = $request['attribute_id'];
        // return $attribute_id;
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
            ProductsAttribute::where('id', $attribute_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'attribute_id'=>$attribute_id]);
        }        
    }

    //  Edit Attribute
    public function editAttributes(Request $request, $id){
        Session::put('page','products');
        if ($request->isMethod('post')) {
           $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attributeId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductsAttribute::where(['id'=> $data['attributeId'][$key]])->update([
                        'price'=> $data['price'][$key],
                        'stock'=> $data['stock'][$key],
                    ]);
                }            
            }
            return redirect()->back()->with('success_message', 'Product Attributes has been Updated Successfully!');
        }
    }

    //  Delete Attribute
    public function deleteAttribute($id){ 
        ProductsAttribute::find($id)->delete();
        $messege = "Product Attribute Delete Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }

    //  Add Images
    public function addImages(Request $request, $id){
        Session::put('page','products');
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('images')->find($id)->toArray();
        // echo "<pre>"; print_r($product); die;   
        if ($request->isMethod('post')) {
            // echo "<pre>"; print_r($request->all()); die;  
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;  
                foreach($images as $key => $image){
                    // $image_tem = Image::make($image);
                    $image_name = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(00000000,99999999).'.'.$extension;
                    
                    //  Generate Location
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;  
                    //  Image Store
                    Image::make($image)->resize(250,250)->save($smallImagePath);
                    Image::make($image)->resize(500,500)->save($mediumImagePath);
                    Image::make($image)->resize(1000,1000)->save($largeImagePath);

                    $data = new ProductImage;
                    $data->image = $imageName;
                    $data->product_id = $id;
                    $data->save(); 
                }
                return redirect()->back()->with('success_message', 'Product Images has been Added Successfully!');
            }   
        }
        return view('admin.images.add_images')->with(compact('product'));
    }

    //  Update Multi Image Status
    public function updateImageStatus(Request $request){
        Session::put('page','products');
        $status = $request['status'];
        $image_id = $request['image_id'];
        // return $image_id;
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
            ProductImage::where('id', $image_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'image_id'=>$image_id]);
        }        
    }

     //  Delete Product Multi Image
     public function deleteImage($id){
        Session::put('page','products');
        // return $id;  
        // return $id;   
        $product_image = ProductImage::where('id', $id)->first();
        // dd($product_image);
        $small_product_image_path = 'front/images/product_images/small/';
        $medium_product_image_path = 'front/images/product_images/medium/';
        $large_product_image_path = 'front/images/product_images/large/';
        // return $banner_path;
        if (!empty($product_image->image) && file_exists($small_product_image_path.$product_image->image)) {
            if (!($product_image->image == 'no_image.jpg')) {
                unlink($small_product_image_path.$product_image->image);
                unlink($medium_product_image_path.$product_image->image);
                unlink($large_product_image_path.$product_image->image);
            }            
        }
        ProductImage::find($id)->delete();
        $messege = "Product Image Delete Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }


   
}
