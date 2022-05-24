<?php
namespace App\Http\Services;

use App\Models\ClassRoomGroup;
use App\Models\Promote;
use App\Models\Student_ClassRoomGroup;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Promotion{

    public function promote($request){
        $dataReq = $request->all();
        // return response()->json($dataReq);
        if($dataReq['oldclassroom'] != $dataReq['newclassroom']){
            // getAllStudentOfThatClassAndUpdate Profile
            $oldStudents = StudentProfile::where('classid', $dataReq['newclassroom'])->get();
            foreach ($oldStudents as $student) {
                $student->promotion_status = 'old';
                $student->save();
                // return response()->json($student);
            }


            // loop array
            foreach ($dataReq['students'] as $data) {
            // update classroom group
            //delete formerClaass
            $student = Student_ClassRoomGroup::where('studentid', $data['id'])->get();
            foreach($student as $student){
                $student = Student_ClassRoomGroup::findOrFail($student->id);
                $student->delete();
            }
            // $student->save();
            $assignClass = new Student_ClassRoomGroup();
            $assignClass->studentid= $data['id'];
            $assignClass->classroomgroupid = $dataReq['newclassroom'];
            $assignClass->createdById = auth('sanctum')->user()->id;;
            $assignClass->save();

            // getYearid
            $yearid = ClassRoomGroup::where('id', $assignClass->classroomgroupid)->first();
            $student = StudentProfile::where('studentuseraccountid', $data['id'])->first();
            // dd($student);
            $student->yearid = $yearid['classgroupid'];
            $student->promotion_status = 'new';
            $student->classid = $assignClass->classroomgroupid;
            $student->save();

            // promote
            $promote = new Promote();
            $promote->studentid =  $data['id'];
            $promote->promoted_from = $dataReq['oldclassroom'];
            $promote->promoted_to = $dataReq['newclassroom'];
            $promote->date = $dataReq['date'];
            $promote->promotedBy = auth('sanctum')->user()->id;;
            $promote->save();
            }
            return response()->json(['message'=>'saved'], 200);
        }else{
            return response()->json(['cannot send to same class'], 500);
        }



        }

}
