<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankController extends Controller
{
    public function index($id){
        $rank = Rank::where('branchid', $id)->get();
        return response()->json($rank);
    }

    public function store(Request $request){
        $data = $request->all();
        $rankData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $rank = new Rank();
        $rank->rank = $rankData['rank'];
        $rank->branchid = $branchid;
        $rank->save();

        return response()->json('saved');

    }

    public function getSingleRank($id){
        $rank = Rank::where('id', $id)->first();
        return response()->json($rank);
    }

    public function updateRank (Request $request, $id){
        $rank = Rank::where('id', $id)->first();
        $data = $request->all();
        $rank->rank = $data['rank'];
        $rank->save();
    }

    public function deleteRank($id){
        Rank::findOrFail($id)->delete();
    }
}
