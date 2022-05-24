<?php

namespace App\Http\Controllers;

use App\Models\Parent_Student;
use App\Models\ParentProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ParentController extends Controller
{
    public function index($id){
        // studentaccountid
        $parents = ParentProfile::select('parent_profiles.*')
        ->join('users', 'parent_profiles.useraccountid', 'users.id')
        ->with('nationality')->with('stateoforigin')->with('country')->with('state')
        ->with('city')->with('createdBy')
        ->where('users.branchid', $id)->get();

        return response()->json($parents);
    }

    public function store(Request $request){
        $data = $request->all();
        // create user account first

        $username = strtolower(substr($data['firstname'], 0,2).substr($data['lastname'],0,6));
        $checkUsername = User::where('username', $username)->first();

        if(! $checkUsername){
            $newUser = new User();
            $newUser->roleid = 5;
            $newUser->username = strtolower(substr($data['firstname'], 0,2).substr($data['contacttel'],0,2));
            $newUser->password = Hash::make(Carbon::today()->toDateString());
            $newUser->stringpassword= Carbon::today()->toDateString();
            $newUser->branchid = $data['branchid'];
            $newUser->save();

            // create profile
            $parentProfile = new ParentProfile();
            $parentProfile->useraccountid = $newUser->id;
            $parentProfile->occupation = $data['occupation'];
            $parentProfile->title = $data['title'];
            $parentProfile->firstname = $data['firstname'];
            $parentProfile->lastname = $data['lastname'];
            $parentProfile->othernames = $data['othernames'];
            $parentProfile->dob = $data['dob'];
            $parentProfile->genderid = $data['genderid'];
            $parentProfile->religion = $data['religion'];
            $parentProfile->nationalityid = $data['nationalityid'];
            $parentProfile->stateoforiginid = $data['stateoforiginid'];
            $parentProfile->local_govt_area = $data['local_govt_area'];
            $parentProfile->address = $data['address'];
            $parentProfile->countryid = $data['countryid'];
            $parentProfile->stateid = $data['stateid'];
            $parentProfile->cityid = $data['cityid'];
            $parentProfile->contactemail = $data['contactemail'];
            $parentProfile->contacttel = $data['contacttel'];
            $parentProfile->photo =$data['photo'];
            $parentProfile->createdById = auth('sanctum')->user()->id;;
            $parentProfile->save();

            return response()->json('profile created');
        }else{
             // create profile
             $parentProfile = new ParentProfile();
             $parentProfile->useraccountid = $checkUsername->id;
             $parentProfile->occupation = $data['occupation'];
             $parentProfile->title = $data['title'];
             $parentProfile->firstname = $data['firstname'];
             $parentProfile->lastname = $data['lastname'];
             $parentProfile->othernames = $data['othernames'];
             $parentProfile->dob = $data['dob'];
             $parentProfile->genderid = $data['genderid'];
             $parentProfile->religion = $data['religion'];
             $parentProfile->nationalityid = $data['nationalityid'];
             $parentProfile->stateoforiginid = $data['stateoforiginid'];
             $parentProfile->local_govt_area = $data['local_govt_area'];
             $parentProfile->address = $data['address'];
             $parentProfile->countryid = $data['countryid'];
             $parentProfile->stateid = $data['stateid'];
             $parentProfile->cityid = $data['cityid'];
             $parentProfile->contactemail = $data['contactemail'];
             $parentProfile->contacttel = $data['contacttel'];
             $parentProfile->photo =$data['photo'];
             $parentProfile->createdById = auth('sanctum')->user()->id;;
             $parentProfile->save();

             return response()->json('profile created');
        }



    }

    public function getSingleParent($id){
        $parent = ParentProfile::select('parent_profiles.*')
        ->join('users', 'parent_profiles.useraccountid', 'users.id')
        ->where('parent_profiles.id', $id)->get();

        return response()->json($parent);
    }

    public function updateParent(Request $request, $id){
        $data = $request->all();
        // return response()->json($request);
        $parentProfile = ParentProfile::findOrFail($id);
        $parentProfile->title = $data['title'];
        $parentProfile->occupation = $data['occupation'];
        $parentProfile->firstname = $data['firstname'];
        $parentProfile->lastname = $data['lastname'];
        $parentProfile->othernames = $data['othernames'];
        $parentProfile->dob = $data['dob'];
        $parentProfile->genderid = $data['genderid'];
        $parentProfile->religion = $data['religion'];
        $parentProfile->nationalityid = $data['nationalityid'];
        $parentProfile->stateoforiginid = $data['stateoforiginid'];
        $parentProfile->local_govt_area = $data['local_govt_area'];
        $parentProfile->address = $data['address'];
        $parentProfile->countryid = $data['countryid'];
        $parentProfile->stateid = $data['stateid'];
        $parentProfile->cityid = $data['cityid'];
        $parentProfile->contactemail = $data['contactemail'];
        $parentProfile->contacttel = $data['contacttel'];
        $parentProfile->photo = $data['photo'];
        // dd($parentProfile);
        $parentProfile->createdById = auth('sanctum')->user()->id;;
        $parentProfile->save();

        return response()->json('profile updated');
    }

    public function deleteParent($id){
        ParentProfile::findOrFail($id)->delete();
        return response()->json('deleted');
    }

    public function parentImage(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/parents'), $fileName);

        return response()->json($fileName);
    }

    public function addWard(Request $request){
        $data = $request->all();
        foreach ($data as $ward) {
            $parentStudent = new Parent_Student();
            $parentStudent->parentid = $ward['parentid'];
            $parentStudent->studentid = $ward['studentid'];
            $parentStudent->createdBy = auth('sanctum')->user()->id;;
            $parentStudent->save();
        }
        return response()->json('data saved' );
    }

    public function getWards(Request $request, $id){
        //getTheWards from table
        $getWards = Parent_Student::select('parent__students.id as pid', 'parent__students.studentid', 'student_profiles.*')
                    ->join('student_profiles', 'parent__students.studentid','student_profiles.studentuseraccountid' )
                    ->where('parent__students.parentid', $id)->get();
        // return response()->json($getWards);
        $myWard = [];
        $studentWardProfile = [];
        // dd($getWards);
        foreach($getWards as $ward){
            //show their profile
            $myWard[]=$ward->studentid;
            foreach($myWard as $student){
                $wardProfile = StudentProfile::where('studentuseraccountid', $student)->get();
            }
            $studentWardProfile[] = $wardProfile;
        }
        // dd(collect($studentWardProfile));
        return response()->json($studentWardProfile);
    }

    public function deleteParentWard($id){
        $ward =  Parent_Student::where('studentid',$id)->first();
        $ward->deleted_at = Carbon::now();
        $ward->save();
    }
}
