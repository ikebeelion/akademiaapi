<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ClassRoomGroup;
use App\Models\Student_ClassRoomGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRoomController extends Controller
{
    public function index($id){
        $classGroups = ClassRoom::where('branchid', $id)->get();
        return response()->json($classGroups);
    }

    public function store(Request $request){
        $data = $request->all();
        $classRoomData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $classRoom = new ClassRoom();
        $classRoom->classroom = $classRoomData['classroom'];
        $classRoom->branchid = $branchid;
        $classRoom->createdById = auth('sanctum')->user()->id;;
        $classRoom->save();

        return response()->json('saved');

    }

    public function getSingleRoom($id){
        $group = ClassRoom::where('id', $id)->first();
        return response()->json($group);
    }

    public function updateRoom(Request $request, $id){
        $room = ClassRoom::where('id', $id)->first();
        $data = $request->all();
        $room->classroom = $data['classroom'];
        $room->save();

    }

    public function deleteRoom($id){
        ClassRoom::findOrFail($id)->delete();
    }

    public function getYearClassRooms($id){
        $classRooms = ClassRoomGroup::where('classgroupid', $id)
                        ->with('classRoom')->get();
        return response()->json($classRooms);
    }

    public function getStudentClassRoom($id){
        $studenclassRoom = Student_ClassRoomGroup::where('studentid', $id)
        ->with('classroomgroup')
        ->join('class_room_groups', 'student__class_room_groups.classroomgroupid', 'class_room_groups.id' )
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->orderBy('student__class_room_groups.created_at', 'DESC')->first();

        return response()->json($studenclassRoom);
    }
}
