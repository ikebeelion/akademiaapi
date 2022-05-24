<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculaController extends Controller
{
    public function store(Request $request){
        $data = $request->all();
        // dd($data['document']);
        $curricula = new Curriculum();
        $curricula->subject_teacher = auth('sanctum')->user()->id;;
        $curricula->file_url = $data['document'];
        $curricula->approval_status = "not-approved";
        $curricula->save();
    }
    public function curriculadoc(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('documents/curricula'), $fileName);
        return response()->json($fileName);
    }
}
