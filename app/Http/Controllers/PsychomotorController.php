<?php

namespace App\Http\Controllers;

use App\Models\Psychomotor_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PsychomotorController extends Controller
{
    public function index($id){
        $psych = Psychomotor_type::where('branchid', $id)->get();
        return response()->json($psych);
    }

    public function store(Request $request){
        $data = $request->all();
        $psychData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $psych = new Psychomotor_type();
        $psych->psychomotor = $psychData['psych'];
        $psych->branchid = $branchid;
        $psych->createdBy = auth('sanctum')->user()->id;;
        $psych->save();

        return response()->json('saved');

    }

    public function getSinglePsych($id){
        $group = Psychomotor_type::where('id', $id)->first();
        return response()->json($group);
    }

    public function updatePsych(Request $request, $id){
        $psych = Psychomotor_type::where('id', $id)->first();
        $data = $request->all();
        $psych->psychomotor = $data['psych'];
        $psych->save();

    }

    public function deletePsych($id){
        Psychomotor_type::findOrFail($id)->delete();
    }
}
