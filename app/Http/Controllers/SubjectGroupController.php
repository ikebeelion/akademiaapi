<?php

namespace App\Http\Controllers;

use App\Models\ClassRoomGroup;
use App\Models\Subject_ClassGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectGroupController extends Controller
{
    public function index($id){
        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id','subject__class_groups.credit_load', 'subject__class_groups.subjectid','subject__class_groups.classgroupid', 'class_groups.classgroupname', 'subjects.subjecttitle')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('class_groups.branchid', $id)
        ->where('subjects.branchid', $id)
        ->get();
        return response()->json($subjectGroup);
    }

    public function indexB($classid){
        $classGroup = ClassRoomGroup::where('id', $classid)->get();

        $classgroupid = $classGroup[0]['classgroupid'];
        // dd($classgroupid);

        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id', 'subject__class_groups.credit_load' ,'subject__class_groups.subjectid','subject__class_groups.classgroupid', 'class_groups.classgroupname', 'subjects.subjecttitle')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        // ->join('class_room_groups', 'subject__class_groups.classgroupid', 'class_room_groups.classgroupid' )
        ->where('subject__class_groups.classgroupid', $classgroupid)
        ->get();
        // dd($subjectGroup);
        return response()->json($subjectGroup);
    }

    public function indexD($classgroupid){
        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id','subject__class_groups.credit_load', 'subject__class_groups.subjectid','subject__class_groups.classgroupid', 'class_groups.classgroupname', 'subjects.subjecttitle')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        // ->join('class_room_groups', 'subject__class_groups.classgroupid', 'class_room_groups.classgroupid' )
        ->where('subject__class_groups.classgroupid', $classgroupid)
        ->get();
        // dd($subjectGroup);
        return response()->json($subjectGroup);
    }

    public function indexC($classid){

        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id','subject__class_groups.credit_load', 'subject__class_groups.subjectid','subject__class_groups.classgroupid', 'class_groups.classgroupname', 'subjects.subjecttitle')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        // ->join('class_room_groups', 'subject__class_groups.classgroupid', 'class_room_groups.classgroupid' )
        ->where('subject__class_groups.classgroupid', $classid)
        ->get();
        // dd($subjectGroup);
        return response()->json($subjectGroup);
    }

    public function resultIndex($classgroupid){

        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id', 'subject__class_groups.subjectid','subject__class_groups.credit_load','subject__class_groups.classgroupid', 'class_groups.classgroupname', 'subjects.subjecttitle')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        // ->join('class_room_groups', 'subject__class_groups.classgroupid', 'class_room_groups.classgroupid' )
        ->where('subject__class_groups.classgroupid', $classgroupid)
        ->get();
        // dd($subjectGroup);
        return response()->json($subjectGroup);
    }



    public function store(Request $request){
        $data = $request->all();
        $subjectGroup = new Subject_ClassGroup();
        $subjectGroup->classgroupid = $data['classgroup'];
        $subjectGroup->subjectid = $data['subject'];
        $subjectGroup->credit_load = $data['load'];
        $subjectGroup->createdById = auth('sanctum')->user()->id;;
        $subjectGroup->save();
        return response()->json('saved');
    }

    public function getSingleSubjectGroup($id){
        $subjectGroup = Subject_ClassGroup::select('subject__class_groups.id','subject__class_groups.credit_load',  'subject__class_groups.subjectid', 'class_groups.classgroupname', 'subjects.subjecttitle', 'subject__class_groups.classgroupid')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('subject__class_groups.id', $id)
        ->first();
        return response()->json($subjectGroup);
    }

    public function updateSubjectGroup(Request $request, $id){
        $subjectGroup = Subject_ClassGroup::where('id', $id)->first();
        $data = $request->all();
        $subjectGroup->classgroupid = $data['classgroup'];
        $subjectGroup->subjectid = $data['subject'];
        $subjectGroup->credit_load = $data['load'];
        $subjectGroup->createdById = auth('sanctum')->user()->id;;
        $subjectGroup->save();
        return response()->json('udpated');
    }

    public function deleteSubjectGroup($id){
        Subject_ClassGroup::findOrFail($id)->delete();
        return response()->json('deleted');
    }


}
