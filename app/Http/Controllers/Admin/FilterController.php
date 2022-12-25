<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Session;
use App\Models\Section;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use DB;

class FilterController extends Controller
{
    // Filters
    public function filters(){
        Session::put('page', 'filters');
        $filters = ProductsFilter::get()->toArray();
        // dd($filters); die;
        return view('admin.filters.filters')->with(compact('filters'));
    }

    //  Update Filter Status
    public function updateFilterStatus(Request $request){
        $status = $request['status'];
        $filter_id = $request['filter_id'];
        // return $filter_id;
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
            ProductsFilter::where('id', $filter_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'filter_id'=>$filter_id]);
        }        
    }

    //  Add Edit Filter
    public function addEditFilter(Request $request, $id=null){
        Session::put('page', "filters");
        if ($id == "") {
            $title = "Add Filter Column";
            $filter = new ProductsFilter;
            $message = "Filter Column Added Successfully..!";
        }else{
            $title = "Edit Filter Column";
            $filter = ProductsFilter::find($id);
            $message = "Filter Column Updated Successfully..!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $cat_ids = implode(',',$data['cat_ids']);

            //  Save filter Column in products table
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['filter_column'];
            $filter->filter_name = $data['filter_name'];
            $filter->save();

            //  add filter column in products table
            DB::statement('Alter table products add '.$data['filter_column'].' varchar(255) after description');

            return redirect('admin/filters')->with('success_message', $message);
        }
        $categories = Section::with('categories')->get()->toArray();
        return view('admin.filters.add_edit_filter')->with(compact('title','filter','categories'));
    }

    // Filters Values
    public function filtersValues(){
        Session::put('page', 'filters');
        $filters_values = ProductsFiltersValue::get()->toArray();
        // dd($filters_values); die;
        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    //  Update Filter Status
    public function updateFilterValueStatus(Request $request){
        $status = $request['status'];
        $filter_id = $request['filter_id'];
        // return $filter_id;
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
            ProductsFiltersValue::where('id', $filter_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'filter_id'=>$filter_id]);
        }        
    }

    //  Add Edit Filter Value
    public function addEditFilterValue(Request $request, $id=null){
        Session::put('page', "filters");
        if ($id == "") {
            $title = "Add Filter Value";
            $filter = new ProductsFiltersValue;
            $message = "Filter Value Added Successfully..!";
        }else{
            $title = "Edit Filter Column";
            $filter = ProductsFiltersValue::find($id);
            $message = "Filter Value Updated Successfully..!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //  Save filter Value in products table
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->save();       

            return redirect('admin/filters-values')->with('success_message', $message);
        }
        $filters = ProductsFilter::where('status',1)->get()->toArray();
        return view('admin.filters.add_edit_filter_value')->with(compact('title','filter','filters'));
    }

    //  Delete Filter Value
    public function deleteFilterValue($id){
        // return $id;        
        ProductsFiltersValue::where('id', $id)->delete();
        $messege = "Filter Value Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }  
    
    public function categoryFilters(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;                        
            $category_id = $data['category_id'];
            return response()->json(['view'=>(String)view('admin.filters.category_filters')->with(compact('category_id'))]);
        }
    }

}
