<?php

namespace App\Http\Controllers;

use App\Http\Services\ClassRoomGroupService;
use App\Models\ClassRoomGroup;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRoomGroupController extends Controller
{
    public function index($id){
        $roomGroup = ClassRoomGroup::select('class_room_groups.id', 'class_groups.classgroupname', 'class_room_groups.classgroupid','class_rooms.classroom')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('class_groups.branchid', $id)
        ->where('class_rooms.branchid', $id)
        ->get();
        return response()->json($roomGroup);
    }

    public function indexB($id){
        $roomGroup = ClassRoomGroup::select('class_room_groups.id', 'class_groups.classgroupname', 'class_rooms.classroom')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('class_groups.id', $id)
        ->get();
        return response()->json($roomGroup);
    }

    public function store(Request $request){
        $data = $request->all();
        $roomGroup = new ClassRoomGroup();
        $roomGroup->classgroupid = $data['classgroup'];
        $roomGroup->classroomid = $data['classroom'];
        $roomGroup->createdById = auth('sanctum')->user()->id;;
        $roomGroup->save();
        return response()->json('saved');
    }

    public function getSingleRoomGroup($id){
        // dd($id);
        $roomGroup = ClassRoomGroup::select('class_room_groups.id', 'class_groups.classgroupname','class_groups.id as classgroupid', 'class_rooms.classroom', 'class_rooms.id as classroomid')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('class_room_groups.id', $id)
        // ->where('class_groups.branchid', $id)
        // ->where('class_rooms.branchid', $id)
        ->first();
        // dd($roomGroup);
        return response()->json($roomGroup);
    }

    public function updateRoomGroup(Request $request, $id){
        $roomGroup = ClassRoomGroup::where('id', $id)->first();
        $data = $request->all();
        $roomGroup->classgroupid = $data['classgroup'];
        $roomGroup->classroomid = $data['classroom'];
        $roomGroup->createdById = auth('sanctum')->user()->id;;
        $roomGroup->save();
        return response()->json('udpated');
    }

    public function deleteRoomGroup($id){
        ClassRoomGroup::findOrFail($id)->delete();
        return response()->json('deleted');
    }
    public function uploadImage(Request $request){
            $extensions = ['jpg', 'png', 'jpeg'];
        if($request->image->getSize() > 1000000){
            return response()->json('file is too large');
        }elseif(!in_array($request->image->extension(), $extensions)){
            return response()->json('invalid format');

        }else{
            $upload = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $upload);
            return response()->json('uploads/'.$upload);
        }
    }
    public function studentsInClassroom(ClassRoomGroupService $classroom, $id){
        $students = $classroom->studentsInClassroom($id);
        return response()->json($students);
    }
}
