<?php

namespace App\Http\Controllers;

use App\Models\Student_ClassRoomGroup;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image;

class StudentController extends Controller
{
    public function getUser($id){
        $students = StudentProfile::where('studentuseraccountid', $id)
                            ->with('classGroup')
                            ->get();
        return response()->json($students);
    }
    public function index($id){
        // studentaccountid
        $students = StudentProfile::select('student_profiles.*')
        ->join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->with('nationality')->with('stateoforigin')->with('country')->with('state')
        ->with('city')->with('classGroup')->with('createdBy')
        ->where('users.branchid', $id)->get();

        return response()->json($students);
    }

    public function store(Request $request){
        $data = $request->all();
        // create user account first
        $username = strtolower(substr($data['firstname'], 0,2).substr($data['lastname'],0,2));
        $checkUsername = User::where('username', $username)->first();

        if(! $checkUsername){
            $newUser = new User();
            $newUser->roleid = 4;
            $newUser->username = strtolower(substr($data['firstname'], 0,2).substr($data['lastname'],0,2));
            $newUser->password = Hash::make($data['dob']);
            $newUser->branchid = $data['branchid'];
            $newUser->save();
            // dd($newUser->id);

            // create profile
            $studentProfile = new StudentProfile();
            $studentProfile->studentuseraccountid = $newUser->id;
            $studentProfile->firstname = $data['firstname'];
            $studentProfile->lastname = $data['lastname'];
            $studentProfile->othernames = $data['othernames'];
            $studentProfile->dob = $data['dob'];
            $studentProfile->genderid = $data['genderid'];
            $studentProfile->religion = $data['religion'];
            $studentProfile->nationalityid = $data['nationalityid'];
            $studentProfile->stateoforiginid = $data['stateoforiginid'];
            $studentProfile->local_govt_area = $data['local_govt_area'];
            $studentProfile->address = $data['address'];
            $studentProfile->countryid = $data['countryid'];
            $studentProfile->stateid = $data['stateid'];
            $studentProfile->cityid = $data['cityid'];
            $studentProfile->enrollmentdate= $data['enrollmentdate'];
            $studentProfile->contactemail = $data['contactemail'];
            $studentProfile->contacttel = $data['contacttel'];
            $studentProfile->yearid = $data['yearid'];
            $studentProfile->photo = $data['photo'];
            $studentProfile->classid = $data['classroom'];
            $studentProfile->createdById = auth('sanctum')->user()->id;;
            $studentProfile->save();

            if($data['classroom'] != null){
                $studentClassRoom = new Student_ClassRoomGroup();
                $studentClassRoom->classroomgroupid = $data['classroom'];
                $studentClassRoom->studentid = $newUser->id;
                $studentClassRoom->createdById =auth('sanctum')->user()->id;;
                $studentClassRoom->save();
            }else{
                //
            }

            return response()->json('profile created');
        }else{
            // create profile
            $studentProfile = new StudentProfile();
            $studentProfile->studentuseraccountid = $checkUsername->id;
            $studentProfile->firstname = $data['firstname'];
            $studentProfile->lastname = $data['lastname'];
            $studentProfile->othernames = $data['othernames'];
            $studentProfile->dob = $data['dob'];
            $studentProfile->genderid = $data['genderid'];
            $studentProfile->religion = $data['religion'];
            $studentProfile->nationalityid = $data['nationalityid'];
            $studentProfile->stateoforiginid = $data['stateoforiginid'];
            $studentProfile->local_govt_area = $data['local_govt_area'];
            $studentProfile->address = $data['address'];
            $studentProfile->countryid = $data['countryid'];
            $studentProfile->stateid = $data['stateid'];
            $studentProfile->cityid = $data['cityid'];
            $studentProfile->enrollmentdate= $data['enrollmentdate'];
            $studentProfile->contactemail = $data['contactemail'];
            $studentProfile->contacttel = $data['contacttel'];
            $studentProfile->yearid = $data['yearid'];
            $studentProfile->photo = $data['photo'];
            $studentProfile->classid = $data['classroom'];
            $studentProfile->createdById = auth('sanctum')->user()->id;;
            $studentProfile->save();

            if($data['classroom'] != null){
                $studentClassRoom = new Student_ClassRoomGroup();
                $studentClassRoom->classroomgroupid = $data['classroom'];
                $studentClassRoom->studentid = $checkUsername->id;
                $studentClassRoom->createdById =auth('sanctum')->user()->id;;
                $studentClassRoom->save();
            }else{
                //
            }

            return response()->json('profile created');
        }



    }

    public function getSingleStudent($id){
        // dd($id);
        $student = StudentProfile::select('student_profiles.*')
        ->join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->where('student_profiles.id', $id)->get();
        return response()->json($student);
    }

    public function updateStudent(Request $request, $id){
        // dd($id);
        $data = $request->all();
        $studentProfile = StudentProfile::findOrFail($id);
        // dd($studentProfile);
        $studentProfile->firstname = $data['firstname'];
        $studentProfile->lastname = $data['lastname'];
        $studentProfile->othernames = $data['othernames'];
        $studentProfile->dob = $data['dob'];
        $studentProfile->genderid = $data['genderid'];
        $studentProfile->religion = $data['religion'];
        $studentProfile->nationalityid = $data['nationalityid'];
        $studentProfile->stateoforiginid = $data['stateoforiginid'];
        $studentProfile->local_govt_area = $data['local_govt_area'];
        $studentProfile->address = $data['address'];
        $studentProfile->countryid = $data['countryid'];
        $studentProfile->stateid = $data['stateid'];
        $studentProfile->cityid = $data['cityid'];
        $studentProfile->enrollmentdate= $data['enrollmentdate'];
        $studentProfile->contactemail = $data['contactemail'];
        $studentProfile->contacttel = $data['contacttel'];
        $studentProfile->yearid = $data['yearid'];
        $studentProfile->photo = $data['photo'];
        $studentProfile->createdById = auth('sanctum')->user()->id;;
        $studentProfile->save();

        return response()->json('profile updated');
    }

    public function deleteStudent($id){
        StudentProfile::findOrFail($id)->delete();
        // User::findOrFail($profile->studentuseraccountid)->delete();
        return response()->json('deleted');
    }

    public function assignToClassRoom(Request $request){
        $data = $request->all();
        //delete formerClaass
        $student = Student_ClassRoomGroup::where('studentid',$data['student'])->get();
        foreach($student as $student){
            $student = Student_ClassRoomGroup::findOrFail($student->id);
            $student->delete();
        }
        // dd($student);
        // $student->save();
        $assignClass = new Student_ClassRoomGroup();
        $assignClass->studentid= $data['student'];
        $assignClass->classroomgroupid = $data['classroom'];
        $assignClass->createdById = auth('sanctum')->user()->id;;
        $assignClass->save();

        $student = StudentProfile::where('studentuseraccountid', $data['student'])->first();
        // dd($student);
        // $student->classroom = $assignClass->id;
        $student->classid = $assignClass->classroomgroupid;
        $student->save();
        return response()->json('saved');
    }

    public function getProfile($id){
        $profile = StudentProfile::where('studentuseraccountid', $id)->first();
        return response()->json($profile);
    }

    public function studentImage(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension ();
        $request->file->move(public_path('images/students'), $fileName);
        return response()->json($fileName);
    }
}
