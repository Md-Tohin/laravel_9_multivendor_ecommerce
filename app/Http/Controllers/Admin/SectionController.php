<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Session;
use Carbon;

class SectionController extends Controller
{
    //  View Sections
    public function sections(){
        Session::put('page', 'section');
        $sections = Section::orderBy('id', 'desc')->get()->toArray();
        // echo "<pre>"; print_r($sections);
        // exit();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    //  Delete Section
    public function deleteSection($id){
        // return $id;        
        Section::where('id', $id)->delete();
        $messege = "Section Deleted Successfully!"; 
        return redirect()->back()->with('success_message',$messege);
    }   

    //  Update Section Status
    public function updateSectionStatus(Request $request){
        $status = $request['status'];
        $section_id = $request['section_id'];
        // return $section_id;
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
            Section::where('id', $section_id)->update(['status' => $status]);
            // return "ok";
            return response()->json(['status'=>$status, 'section_id'=>$section_id]);
        }        
    }

    // Add Edit Section 
    public function addEditSection(Request $request, $id=null){
        Session::put('page', 'section');
        if ($id=="") {
            $title = "Add Section";
            $section = new Section;
            $messege = "Section Added Successfully!";
        }
        else{
            $title = "Edit Section";
            $section = Section::find($id);
            $messege = "Section Updated Successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);
            // exit();
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $coustomMessages = [
                'name.required' => 'Section name is required',
                'name.regex' => 'Valid Name is required',
            ];
            $this->validate($request, $rules, $coustomMessages);                 
            $section->name = $data['name'];
            $section->save();
            return redirect('admin/sections')->with('success_message', $messege);
        }

        return view('admin.sections.add_edit_section')->with(compact('title', 'section', 'messege'));
    }

}
