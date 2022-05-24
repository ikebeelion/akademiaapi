<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index($classroom, $subject){
        $assignments = DB::table('assignments')->select('assignments.id as assid','assignments.submission_date','subjects.subjecttitle', 'class_groups.classgroupname','class_rooms.classroom')
        ->join('class_room_groups', 'assignments.classid', 'class_room_groups.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->join('subject__class_groups', 'assignments.subjectid', 'subject__class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('assignments.subjectid', $subject)
        ->where('assignments.classid', $classroom)
        ->where('assignments.deleted_at', null)
        ->get();

        return response()->json($assignments);
    }

    public function store(Request $request){
        $data = $request->all();
        // dd($data);
        $assignment = new Assignment();
        $assignment->subjectid = $data['subdetail']['subject'];
        $assignment->classid =$data['classroom'];
        $assignment->description =$data['description'];
        $assignment->submission_date =$data['submission_date'];
        $assignment->image = $data['image'];
        $assignment->createdBy = auth('sanctum')->user()->id;;
        $assignment->save();

        return response()->json('saved');

    }

    public function geSingleAssignment($id){
        $assignments = DB::table('assignments')->select('assignments.id as assid','assignments.image','assignments.description','assignments.subjectid','assignments.classid','assignments.submission_date','subjects.subjecttitle', 'class_groups.classgroupname','class_rooms.classroom')
        ->join('class_room_groups', 'assignments.classid', 'class_room_groups.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->join('subject__class_groups', 'assignments.subjectid', 'subject__class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('assignments.id', $id)
        ->get();

        return response()->json($assignments);
    }

    public function updateAssignment(Request $request, $id){
        $data = $request->all();

        $assignment = Assignment::findOrFail($id);
        $assignment->subjectid = $data['subdetail']['subject'];
        $assignment->classid =$data['classroom'];
        $assignment->description =$data['description'];
        $assignment->submission_date =$data['submission_date'];
        $assignment->image = $data['image'];
        $assignment->save();

        return response()->json('updated');

    }

    public function deleteAssignment($id){
        Assignment::findOrFail($id)->delete();
        return response()->json('deleted');
    }

    public function uploadImage(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/assignment'), $fileName);
        return response()->json($fileName);
    }
}
