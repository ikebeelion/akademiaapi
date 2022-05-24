<?php

namespace App\Http\Controllers;

use App\Http\Services\ResultService;
use App\Models\AffectiveDomain;
use App\Models\ClassRoomGroup;
use App\Models\Psychomotor;
use App\Models\Remark;
use App\Models\Result;
use App\Models\ResultType;
use App\Models\resultTypeData;
use App\Models\Student_ClassRoomGroup;
use App\Models\StudentProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Http\Services\multiplyArrays;

class ResultController extends Controller
{
    public function index($id){
        $rank = ResultType::where('branchid', $id)->get();
        return response()->json($rank);
    }

    public function store(Request $request){
        $data = $request->all();
        $resultTypeData = $data[0];
        $branchid = $data[1];
        $type = new ResultType();
        $type->resulttype = $resultTypeData['type'];
        $type->percentage = $resultTypeData['percentage'];
        $type->branchid = $branchid;
        $type->createdBy = auth('sanctum')->user()->id;;
        $type->save();

        return response()->json('saved');

    }

    public function getSingleType($id){
        $result_type = ResultType::where('id', $id)->first();
        return response()->json($result_type);
    }

    public function updateType (Request $request, $id){
        $result_type = ResultType::where('id', $id)->first();
        $data = $request->all();
        $result_type->resulttype = $data['type'];
        $result_type->percentage = $data['percentage'];
        $result_type->save();
    }

    public function deleteType($id){
        ResultType::findOrFail($id)->delete();
    }

    public function scoreStudent(Request $request){
        $data = $request->all();
        $result = new Result();
        $result->restult_typeid = $data['resultTypeid'];
        $result->studentid = $data['studentid'];
        $result->academic_periodid = $data['academicPeriodid'];
        $result->subjectid = $data['subjectid'];
        $result->classroomid = $data['classid'];
        $result_type = ResultType::where('id', $data['resultTypeid'])->get();
        // dd($result_type);
        $result->createdById = auth('sanctum')->user()->id;;
        if($data['score'] <= $result_type[0]->percentage){
            $result->score_obtained = $data['score'];
        }else{
            return response()->json(['message'=>'Assigned scored is greater than the score for this result type'], 400);
        }
        $result->save();
    }

    public function storeClassResult(ResultService $service, Request $request){
        $storeResult = $service->storeClassResult($request);
        return response()->json($storeResult);
    }

    public function getResultProfile($studentid){
         // getstudent profile from periodid
         $profile = Result::join('student_profiles', 'results.studentid', 'student_profiles.studentuseraccountid')
         ->join('class_room_groups', 'results.classroomid', 'class_room_groups.id')
         ->join('class_groups','class_room_groups.classgroupid', 'class_groups.id')
         ->join('class_rooms','class_room_groups.classroomid', 'class_rooms.id')
         ->join('term__session__years', 'results.academic_periodid', 'term__session__years.id')
        ->join('result_types', 'results.restult_typeid', 'result_types.id')
         ->join('terms', 'term__session__years.termid', 'terms.id')
         ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
         ->join('academic_years', 'term__session__years.yearid', 'academic_years.id')
         ->where('studentid', $studentid)->groupBy('studentid')->first();

         return response()->json($profile);
    }

    public function getStudentCount($roomgroupid){
        $students_in_class = Student_ClassRoomGroup::where('classroomgroupid', $roomgroupid)->count();

        return response()->json($students_in_class);
    }

    public function getResult($studentid, $periodid, $subjectid){
        // getResult (result,remarks,psychomotor) based on periodid
        $result = Result::join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')
        ->join('term__session__years', 'results.academic_periodid', 'term__session__years.id')
        ->join('result_types', 'results.restult_typeid', 'result_types.id')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
        ->join('academic_years', 'term__session__years.yearid', 'academic_years.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
        ->where('results.studentid', $studentid)
        ->where('results.academic_periodid', $periodid)
        ->where('results.subjectid', $subjectid)
        ->get();
        return response()->json($result);
    }

    public function getSessionResult(ResultService $service, $studentid, $periodid){
        $result = $service->sessionResult($studentid, $periodid);
        return response()->json($result);
    }

    public function getPeriodResult($studentid, $periodid){
        $result = Result::select('results.restult_typeid','results.score_obtained','results.subjectid as resultsubject', 'subject__class_groups.*','class_groups.*','subjects.*')->
                join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')->
                join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
                ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                ->where('studentid', $studentid)
                ->where('academic_periodid', $periodid)
                ->get();
        return response()->json($result);
    }


    public function getPeriodResultTotalCredit($studentid, $periodid){
        $result = Result::select('subject__class_groups.credit_load')->join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')->
                join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
                ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                ->where('studentid', $studentid)
                ->where('academic_periodid', $periodid)
                ->groupBy('results.subjectid')->get();
        return response()->json($result);
    }


    public function getPeriodResultTotalPoints($studentid, $periodid){
        $totalCredit = Result::join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')->
                join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
                ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                ->where('studentid', $studentid)
                ->where('academic_periodid', $periodid)
                ->groupBy('results.subjectid')->get();
            $loads = [];
            foreach ($totalCredit as $totalCredit) {
                array_push($loads, $totalCredit->credit_load);
            }
            $totalCreditLoad = (array_sum($loads));

            $res = Result::select('results.restult_typeid','results.score_obtained','results.subjectid as resultsubject', 'subject__class_groups.*','class_groups.*','subjects.*')->
            join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')->
            join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
            ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
            ->where('studentid', $studentid)
            ->where('academic_periodid', $periodid)
            ->groupBy('results.subjectid')->get();

            $resultGroup = [];
            foreach ($res as $result) {
                array_push($resultGroup, $result->resultsubject);
            }
            // loop all subjects in resultGroup
            $groupedResult = [];
            foreach ($resultGroup as $group) {
                // sum score obtained
                $res = Result::select('results.restult_typeid','results.score_obtained','results.subjectid as resultsubject', 'subject__class_groups.*','class_groups.*','subjects.*')->
                        join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')->
                        join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
                        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                        ->where('studentid', $studentid)
                        ->where('results.subjectid', $group)->sum('results.score_obtained');
                array_push($groupedResult, $res);
            }
            $totalScores = array_sum($groupedResult);
            $pointsArray = [];
            foreach ($groupedResult as $gradepoint) {
                if($gradepoint > 70){
                    array_push($pointsArray,5);
                }
                if($gradepoint >= 60 && $gradepoint < 70){
                    array_push($pointsArray,  4 );
                }
                if($gradepoint >= 50 && $gradepoint < 60){
                    array_push($pointsArray, 3 );
                }
                if($gradepoint >= 40 && $gradepoint < 50){
                    array_push($pointsArray, 1 );
                }
                if($gradepoint < 40){
                    array_push($pointsArray, 0 );
                }
            }

            // multiply points array and loads
            $totalCreditPoints = 0;
            $computed = [];
            for($index = 0; $index < count($pointsArray); $index++){
                array_push($computed, $pointsArray[$index] * $loads[$index]);
            }

            $gpa = array_sum($computed)/$totalCreditLoad;
            $average = $totalScores/count($groupedResult);

            return response()->json(
                [
                    'gpa'=>$gpa,
                    'average'=>$average,
                    'totalPoints'=>array_sum($computed),
                    'totalCredit'=>$totalCreditLoad

                ]
            );

    }

public function getDomain($studentid, $periodid){
    $psych = AffectiveDomain::join('affective_domain_types', 'affective_domains.affective_domainid', 'affective_domain_types.id')
                ->where('affective_domains.studentid', $studentid)
                ->where('affective_domains.academic_periodid', $periodid)
                ->where('affective_domains.deleted_at', null)
                ->get();
    return response()->json($psych);
}

public function deleteDomain(Request $request){
    $data = $request->all();
    // FIRST CHECK WHERE ACADEMIC PERIOD ID AND STUDENT ID EXISTS AND DELETE SOFTLY
    $delete = AffectiveDomain::where('studentid', $data['studentid'])
                ->where('academic_periodid', $data['academicPeriodid'])->get();
    foreach($delete as $delete){
        $delete->deleted_at = Carbon::now();
        $delete->save();
    }

    // // remark delete also
    // $remarkDelete  = Remark::where('studentid', $data['studentid'])
    // ->where('academic_periodid', $data['academicPeriodid'])->get();

    // foreach($remarkDelete as $delete){
    //     $delete->deleted_at = Carbon::now();
    //     $delete->save();
    // }
}
public function storeDomain(Request $request){
    $data = $request->all();
    // STORE NEW PSYCHOMOTOR
    $data_to_persist = [];
    // dd($data['affective_domain']);
    foreach($data['affective_domain'] as $domain){
            array_push( $data_to_persist, [
                'studentid' => $data['studentid'],
                'academic_periodid' => $data['academicPeriodid'],
                'affective_domainid'=>$domain['domaintype'],
                'rating' => $domain['rating'],
                'createdBy' => auth('sanctum')->user()->id,
            ]);
        }
    AffectiveDomain::insert($data_to_persist);


}

    public function getRemark($studentid, $periodid){
        $remark = Remark::where('studentid', $studentid)
                ->where('academic_periodid', $periodid)
                ->where('deleted_at', null)
                ->get();

        return response()->json($remark);
    }

    public function getPsychomotor($studentid, $periodid){
        $psych = Psychomotor::join('psychomotor_types', 'psychomotors.psychomotorid', 'psychomotor_types.id')
                    ->where('psychomotors.studentid', $studentid)
                    ->where('psychomotors.academic_periodid', $periodid)
                    ->where('psychomotors.deleted_at', null)
                    ->get();
        return response()->json($psych);
    }

    public function deletePsychomotor(Request $request){
        $data = $request->all();
        // FIRST CHECK WHERE ACADEMIC PERIOD ID AND STUDENT ID EXISTS AND DELETE SOFTLY
        $delete = Psychomotor::where('studentid', $data['studentid'])
                    ->where('academic_periodid', $data['academicPeriodid'])->get();
        foreach($delete as $delete){
            $delete->deleted_at = Carbon::now();
            $delete->save();
        }

        // remark delete also
        $remarkDelete  = Remark::where('studentid', $data['studentid'])
        ->where('academic_periodid', $data['academicPeriodid'])->get();

        foreach($remarkDelete as $delete){
            $delete->deleted_at = Carbon::now();
            $delete->save();
        }
    }
    public function storePsychomotor(Request $request){
        $data = $request->all();
        // STORE NEW PSYCHOMOTOR
        $data_to_persist = [];
        // dd($data['psychomotor']['psychtype']);
        foreach($data['psychomotor'] as $psychomotor){
                array_push( $data_to_persist, [
                    'studentid' => $data['studentid'],
                    'academic_periodid' => $data['academicPeriodid'],
                    'psychomotorid' => $psychomotor['psychtype'],
                    'rating' => $psychomotor['rating'],
                    'createdBy' => auth('sanctum')->user()->id,
                ]);
            }
        Psychomotor::insert($data_to_persist);

        // STORE NEW REMARK
        $remark = new Remark();
        $remark->studentid = $data['studentid'];
        $remark->academic_periodid = $data['academicPeriodid'];
        $remark->teacher_remark = $data['remarks']['teacher'];
        $remark->principal_remark = $data['remarks']['principal'];
        $remark->createdBy = auth('sanctum')->user()->id;;
        $remark->save();
    }

    public function getScoredStudents(ResultService $request, $periodid, $subjectid, $resulttype){
        $scoredStudents = $request->get_scored_students($periodid, $subjectid, $resulttype);
        return $scoredStudents;
    }


}
