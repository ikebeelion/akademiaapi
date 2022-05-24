<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index($id){
        $branch = Branch::where('schoolid', $id)
        ->with('country')
        ->with('state')
        ->with('city')
        ->get();
        return response()->json($branch);
    }

    public function store(Request $request){
        $data = $request->all();
        $branch_details = $data[0];
        $school_id = $data[1];
        $branch = new Branch();
        $branch->branchname = $branch_details['branchname'];
        $branch->schoolid = $school_id;
        $branch->branchaddress = $branch_details['branchaddress'];
        $branch->countryid = $branch_details['countryid'];
        $branch->stateid = $branch_details['stateid'];
        $branch->cityid = $branch_details['cityid'];
        $branch->branchtel = $branch_details['branchtel'];
        $branch->save();
    }

    public function getSingleBranch($id){
        $branch = Branch::where('id', $id)->first();
        return response()->json($branch);
    }

    public function updateBranch(Request $request, $id){
        $branch = Branch::where('id', $id)->first();
        $data = $request->all();

        $branch->branchname = $data['branchname'];
        $branch->branchaddress = $data['branchaddress'];
        $branch->countryid = $data['countryid'];
        $branch->stateid = $data['stateid'];
        $branch->cityid = $data['cityid'];
        $branch->branchtel = $data['branchtel'];
        // dd($branch);
        $branch->save();
        return response()->json('updated');
    }

    public function deleteBranch($id){
        Branch::findOrFail($id)->delete();
        return response()->json('deleted');
    }
}
