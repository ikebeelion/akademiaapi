<?php
namespace App\Http\Services;

use App\Models\AttendanceCount;
use App\Models\Request;
use App\Models\Result;
use App\Models\ResultType;

class ResultService{

    public function validateResultType($request){
        $result_type = ResultType::where('id', $request->restult_typeid)->first();
            if($request->score_obtained <= $result_type->percentage){

            }else{
                return response()->json(['message'=>'Assigned scored is greater than the score for this result type'], 400);
            }
    }

    // store only CA OR ONLY RESULT
    public function storexClassResult($req){
        dd($req);
        $data_to_persist = [];
        foreach (collect($req) as $request) {
            array_push($data_to_persist, [
                'restult_typeid' => $request['restult_typeid'],
                'studentid' => $request['studentid'],
                'academic_periodid' => $request['academic_periodid'],
                'subjectid' => $request['subjectid'],
                'classroomid' => $request['classroomid'],
                'score_obtained'=>$request['score_obtained'],
                'createdById' => auth('sanctum')->user()->id,
            ]);
        }
        Result::insert($data_to_persist);
        return response()->json(['message'=>'saved'], 200);
    }

    // store CA and Result in mass

    public function storeClassResult($req){
        $data_to_persist = [];
        foreach ($req->toArray() as $request) {
            array_push($data_to_persist, [
                'restult_typeid' => $request['restult_typeid'],
                'studentid' => $request['studentid'],
                'academic_periodid' => $request['academic_periodid'],
                'subjectid' => $request['subjectid'],
                'classroomid' => $request['classroomid'],
                'score_obtained'=>$request['score_obtained'],
                'createdById' => auth('sanctum')->user()->id,
            ]);

        }
        Result::insert($data_to_persist);
        // AttendanceCount::insert($attendance_data);
        return response()->json(['message'=>'saved'], 200);

    }

    public function sessionResult($studentid, $sessionid){
        $result = Result::join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')
        ->join('term__session__years', 'results.academic_periodid', 'term__session__years.id')
        ->join('result_types', 'results.restult_typeid', 'result_types.id')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
        ->join('academic_years', 'term__session__years.yearid', 'academic_years.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->where('term__session__years.sessionid', $sessionid)
        ->where('results.studentid', $studentid)->groupBy('term__session__years.termid')->groupBy('results.restult_typeid')
        ->get();

        return response()->json($result);
    }

    public function get_scored_students($periodid, $subjectid, $resulttype){
        $getScored = Result::where('academic_periodid', $periodid)
                            ->where('subjectid', $subjectid)
                            ->where('restult_typeid', $resulttype)
                            ->get();

        return response()->json($getScored);
    }
}
