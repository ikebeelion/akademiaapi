<?php

namespace App\Http\Controllers;

use App\Models\PerformanceComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($periodid, $studentid){
        $performance_comment = PerformanceComment::join('subject__class_groups', 'performance_comments.subjectid', 'subject__class_groups.id')
        ->join('term__session__years', 'performance_comments.academic_periodid', 'term__session__years.id')
        ->join('terms', 'term__session__years.termid', 'terms.id')
        ->join('academic_sessions', 'term__session__years.sessionid', 'academic_sessions.id')
        ->join('academic_years', 'term__session__years.yearid', 'academic_years.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->join('class_groups', 'subject__class_groups.classgroupid', 'class_groups.id')
                    ->where('academic_periodid', $periodid)
                    ->where('studentid', $studentid)
                    ->get();

                return response()->json($performance_comment);
    }

    public function storeComment(Request $request){
        $data = $request->all();
        // dd($data);

        // STORE NEW comment
        $comment = new PerformanceComment();
        $comment->studentid = $data['studentid'];
        $comment->academic_periodid = $data['academicPeriodid'];
        $comment->teacher_remark = $data['comment'];
        $comment->subjectid = $data['subjectid'];
        $comment->ca = $data['ca'];
        $comment->exam = $data['exam'];
        $comment->score = $data['score'];
        $comment->avg = $data['avg'];
        $comment->createdBy = auth('sanctum')->user()->id;;
        $comment->save();
    }

    public function updateComment(Request $request, $id){
        $data = $request->all();
        $comment = PerformanceComment::findOrFail($id);
        $comment->studentid = $data['studentid'];
        $comment->academic_periodid = $data['academicPeriodid'];
        $comment->subjectid = $data['subjectid'];
        $comment->teacher_remark = $data['comment'];
        $comment->ca = $data['ca'];
        $comment->exam = $data['exam'];
        $comment->score = $data['score'];
        $comment->avg = $data['avg'];
        $comment->createdBy = auth('sanctum')->user()->id;;
        $comment->save();
    }

    public function delete($id){
        PerformanceComment::findOrFail($id)->delete();
    }
}
