<?php

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassGroupController extends Controller
{
    public function index($id){
        $classGroups = ClassGroup::where('branchid', $id)->get();
        return response()->json($classGroups);
    }

    public function store(Request $request){
        $data = $request->all();
        $classGroupData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $classGroups = new ClassGroup();
        $classGroups->classgroupname = $classGroupData['classgroupname'];
        $classGroups->branchid = $branchid;
        $classGroups->createdById = auth('sanctum')->user()->id;;
        $classGroups->save();

        return response()->json('saved');

    }

    public function getSingleGroup($id){
        $group = ClassGroup::where('id', $id)->first();
        return response()->json($group);
    }

    public function updateGroup(Request $request, $id){
        $group = ClassGroup::where('id', $id)->first();
        $data = $request->all();
        $group->classgroupname = $data['classgroupname'];
        $group->save();

    }

    public function deleteGroup($id){
        ClassGroup::findOrFail($id)->delete();
    }
}
