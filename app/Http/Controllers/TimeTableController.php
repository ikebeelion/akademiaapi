<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeTableController extends Controller
{
    public function classRoomTable($branchid, $classRoomGroupid){
        $timetable = Timetable::where('branchid', $branchid)
        ->where('classRoomGroupid', $classRoomGroupid)->get();
        return response()->json($timetable);
    }

    public function classGroupTable($branchid, $classGroupId){
        $timetable = Timetable::where('branchid', $branchid)
        ->where('classGroupId', $classGroupId)->get();
        return response()->json($timetable);
    }

    public function store(Request $request){
        $data = $request->all();
        $data_to_persist = [];
    // dd($data['affective_domain']);
        foreach($data as $data){
                array_push( $data_to_persist, [
                    'classRoomGroupid' => $data['classGroupId']['roomid'],
                    'classGroupId' => $data['classGroupId']['classid'],
                    'timetabletype' =>	$data['timetabletype'],
                    'subjectid' =>	$data['subjectid']['subjectid'],
                    'academic_periodid' =>	$data['academicPeriodid']['periodid'],
                    'from' =>	$data['from'], //timestart
                    'to' =>	$data['to'], //timeend
                    'day' =>	$data['day'], //day
                    'date' =>	$data['date'], //date
                    'status' => 'not_approved',
                    'branchid' => $data['branchid'],
                    'createdById' => auth('sanctum')->user()->id,
                ]);
            }

            Timetable::insert($data_to_persist);

    }

    public function getSingleTable($id){
        $timetable = Timetable::findOrFail($id);
        return response()->json($timetable);
    }

    public function updateTable(Request $request, $id){
        $data = $request->all();
        $timetable = Timetable::findOrFail($id);
        $timetable->classRoomGroupid = $data['classRoomGroupid'];
        $timetable->classGroupId = $data['classGroupId'];
        $timetable->timetabletype =	$data['timetabletype'];
        $timetable->subjectid =	$data['subjectid'];
        $timetable->academic_periodid =	$data['academic_periodid'];
        $timetable->from =	$data['from']; //timestart
        $timetable->to =	$data['to']; //timeend
        $timetable->day =	$data['day']; //day
        $timetable->date =	$data['date']; //date
        $timetable->status = $data['status'];
        $timetable->save();
    }

    public function deleteTable($id){
        Timetable::findOrFail($id)->delete();
    }

    public function getExamTimeTable($classgroup, $period){
        $timetable = Timetable::join('class_groups', 'timetables.classGroupId', 'class_groups.id')
        ->join('subject__class_groups', 'timetables.subjectid', 'subject__class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('timetables.timetabletype', 'exam_timetable')
        ->where('timetables.classGroupId', $classgroup)
        ->where('timetables.academic_periodid', $period)->get();

        return response()->json($timetable);
    }

    public function getClassTimeTable($classroom, $period){
        $timetable = Timetable::join('class_room_groups', 'timetables.classRoomGroupid', 'class_room_groups.id' )
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('subject__class_groups', 'timetables.subjectid', 'subject__class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('timetables.timetabletype', 'class_timetable')
        ->where('timetables.classRoomGroupid', $classroom)
        ->where('timetables.academic_periodid', $period)->get();

        return response()->json($timetable);
    }

    // getUnapprovedTable
    public function getTable($branchid){
        $timetable = Timetable::select('timetables.status as t_status','timetables.id as tid', 'timetables.*', 'class_groups.*',
        'subject__class_groups.*','subjects.*','term__session__years.*','terms.*',
        'academic_sessions.*','class_room_groups.*','class_rooms.*')
         ->join('class_groups', 'timetables.classGroupId', 'class_groups.id')
        ->join('subject__class_groups', 'timetables.subjectid', 'subject__class_groups.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->join('term__session__years', 'timetables.academic_periodid', 'term__session__years.id')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
        ->join('academic_years', 'term__session__years.yearid', 'academic_years.id')
        ->join('class_room_groups', 'timetables.classRoomGroupid', 'class_room_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('timetables.branchid', $branchid)->where('timetables.status', 'not_approved')->get();
        return response()->json($timetable);
    }

    //Approve
    public function approveTable($id){
        $timetable = Timetable::findOrFail($id);
        $timetable->status = 'approved';
        $timetable->save();
    }

        //Approve
    public function disapproveTable($id){
            $timetable = Timetable::findOrFail($id);
            $timetable->status = 'not_approved';
            $timetable->save();
    }

}
