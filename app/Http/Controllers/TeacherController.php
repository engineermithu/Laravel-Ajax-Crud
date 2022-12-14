<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use DB;

class TeacherController extends Controller
{
    public function index(){

        return view('teacher.index');
    }

    public function allData(){

       $data = Teacher::latest()->get();

       return response()->json($data);
    }

    public function storeData(Request $request){

       $data = Teacher::insert([
             'name' => $request->name,
           'title' => $request->title,
           'institute' =>$request->institute,
       ]);

       return response()->json($data);
    }

    public function editData($id){

        $data  = Teacher::findOrFail($id);
       return response()->json($data);
    }

    public function updateData(Request $request,$id){

        $data = Teacher::findOrFail($id)->update([
            'name' => $request->name,
            'title' => $request->title,
            'institute' =>$request->institute,
        ]);
       return response()->json($data);
    }


  public function deleteData($id){

        $data = Teacher::findOrFail($id)->delete();

        return response()->json($data);
    }


}
