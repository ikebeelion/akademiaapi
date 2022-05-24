<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\Term_Session_Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TimelineController extends Controller
{
    public function store_year(Request $request){
        $data = $request->all();
        $year = $data[0]['year'];
        $branchid = $data[1]['branchid'];

        $academic_year = new AcademicYear();
        $academic_year->year = $year;
        $academic_year->branchid = $branchid;
        $academic_year->created_by = auth('sanctum')->user()->id;;

        $academic_year->save();
    }
    public function store_term(Request $request){
        $data = $request->all();
        $term = $data[0]['term'];
        $branchid = $data[1]['branchid'];

        $academic_term = new Term();
        $academic_term->term = $term;
        $academic_term->branchid = $branchid;
        $academic_term->createdById = auth('sanctum')->user()->id;;

        $academic_term->save();
    }
    public function store_session(Request $request){
        $data = $request->all();
        $session = $data[0];
        $branchid = $data[1]['branchid'];


        $academic_session = new AcademicSession();
        $academic_session->session = $session['session'];
        $academic_session->startdate = $session['startdate'];
        $academic_session->enddate = $session['enddate'];
        $academic_session->branchid = $branchid;
        $academic_session->status =1;
        $academic_session->createdById = auth('sanctum')->user()->id;;
        $academic_session->save();
    }

    public function getSession($id){
        $sessions = AcademicSession::where('branchid', $id)->get();
        return response()->json($sessions);
    }


    public function getTerm($id){
        $terms = Term::where('branchid', $id)->get();
        return response()->json($terms);
    }

    public function getYear($id){
        $years = AcademicYear::where('branchid', $id)->get();
        return response()->json($years);
    }

    public function getPeriod($id){
        $academicPeriod = Term_Session_Year::select('term__session__years.*', 'terms.id as termid', 'terms.term', 'terms.branchid')->with('session')
        ->with('year')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->where('terms.branchid', $id)
        ->get();
        return response()->json($academicPeriod);
    }

    public function getActivePeriod($id){
        $academicPeriod = Term_Session_Year::select('term__session__years.id as period')->with('term')
        ->with('session')
        ->with('year')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
        ->where('terms.branchid', $id)
        ->where('academic_sessions.status', 1)
        ->first();
        return response()->json($academicPeriod);
    }

    public function addPeriod(Request $request){
        $data = $request->all();
        $period = new Term_Session_Year();
        $period->termid = $data['termid'];
        $period->sessionid = $data['sessionid'];
        $period->yearid = $data['yearid'];
        $period->next_resumption = $data['next_resumption'];
        $period->createdById = auth('sanctum')->user()->id;;
        $period->save();
    }
}
