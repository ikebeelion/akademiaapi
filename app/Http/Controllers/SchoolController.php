<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\StaffProfile;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index($id){
        $school = School::findOrFail($id);
//d
        return response()->json($school);
    }

    public function updateProfile(Request $request, $id){
        $school = School::findOrFail($id);
        $data = $request->all();
        $school->schoolname = $data['schoolname'];
        $school->alias = $data['alias'];
        $school->schoolemail = $data['schoolemail'];
        $school->schooltel = $data['schooltel'];
        $school->schoolmotto = $data['schoolmotto'];
        $school->schoollogo = $data['schoollogo'];
        $school->address = $data['address'];
        $school->countryid = $data['countryid'];
        $school->stateid = $data['stateid'];
        $school->cityid = $data['cityid'];
        $school->year_of_establishment = $data['year_of_establishment'];
        $school->schoolzone = $data['schoolzone'];
        $school->schoolchapter = $data['schoolchapter'];
        $school->associationAffiliation = $data['associationAffiliation'];
        $school->educationDistrict = $data['educationDistrict'];
        $school->save();

    }

    public function submitImage(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/school'), $fileName);
        return response()->json($fileName);
    }

    public function principalOfficer($id){
        $staff = StaffProfile::select('staff_profiles.*')
        ->join('users', 'staff_profiles.staffuseraccountid', 'users.id')
        // ->where('staff_profiles.id', $id)
        ->where('staff_profiles.rankid', 1)->get();
        return response()->json($staff);
    }

}
