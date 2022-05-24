<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index($id){
        $subject = Subject::where('branchid', $id)->get();
        return response()->json($subject);
    }

    public function store(Request $request){
        $data = $request->all();
        $subjectData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $subject = new Subject();
        $subject->subjecttitle = $subjectData['subjecttitle'];
        $subject->subject_alias = $subjectData['subject_alias'];
        $subject->branchid = $branchid;
        $subject->createdById = auth('sanctum')->user()->id;
        $subject->save();

        return response()->json('saved');

    }

    public function getSingleSubject($id){
        $group = Subject::where('id', $id)->first();
        return response()->json($group);
    }

    public function updateSubject(Request $request, $id){
        $subject = Subject::where('id', $id)->first();
        $data = $request->all();
        $subject->subjecttitle = $data['subjecttitle'];
        $subject->subject_alias = $data['subject_alias'];
        $subject->save();

    }

    public function deleteSubject($id){
        Subject::findOrFail($id)->delete();
    }

}
