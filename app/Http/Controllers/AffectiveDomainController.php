<?php

namespace App\Http\Controllers;

use App\Models\AffectiveDomain;
use App\Models\AffectiveDomainTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffectiveDomainController extends Controller
{
    public function index($id){
        $domain = AffectiveDomainTypes::where('branchid', $id)->get();
        return response()->json($domain);
    }

    public function store(Request $request){
        $data = $request->all();
        $psychData = $data[0];
        $branchid = $data[1];
        // dd($data);
        $domain = new AffectiveDomainTypes();
        $domain->affective_domain = $psychData['affective_domain'];
        $domain->branchid = $branchid;
        $domain->createdBy = auth('sanctum')->user()->id;;
        $domain->save();

        return response()->json('saved');

    }

    public function getSingleDomain($id){
        $group = AffectiveDomainTypes::where('id', $id)->first();
        return response()->json($group);
    }

    public function updateDomain(Request $request, $id){
        $domain = AffectiveDomainTypes::where('id', $id)->first();
        $data = $request->all();
        $domain->affective_domain = $data['affective_domain'];
        $domain->save();

    }

    public function deleteDomain($id){
        AffectiveDomainTypes::findOrFail($id)->delete();
    }
}
