<?php

namespace App\Http\Controllers;

use App\Models\StaffProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStudentCount($schoolId){
        $count = User::join('branches', 'users.branchid','branches.id')
                        ->where('branches.schoolid', $schoolId)
                        ->where('users.roleid', 4)->count();
        return response()->json($count);
    }

    public function getStaffCount($schoolId){
        $count = StaffProfile::join('users', 'staff_profiles.staffuseraccountid', 'users.id')
            ->join('branches', 'users.branchid','branches.id')
            ->where('branches.schoolid', $schoolId)
            ->where('users.roleid', 3)
            ->count();
        return response()->json($count);
    }

    public function getTeachingStaffCount($schoolId){
        $count = StaffProfile::join('users', 'staff_profiles.staffuseraccountid', 'users.id')
                        ->join('branches', 'users.branchid','branches.id')
                        ->where('branches.schoolid', $schoolId)
                        ->where('users.roleid', 3)
                        ->where('staff_profiles.staff_type', 'teaching')->count();
        return response()->json($count);
    }

    public function getNonTeachingStaffCount($schoolId){
        $count = StaffProfile::join('users', 'staff_profiles.staffuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('users.roleid', 3)
        ->where('staff_profiles.staff_type', 'non-teaching')->count();
        return response()->json($count);

    }

    public function getMaleStudents($schoolId){
        $count = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('student_profiles.genderid', 'male')->count();
        return response()->json($count);
    }

    public function getFemaleStudents($schoolId){
        $count = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('student_profiles.genderid', 'female')->count();
        return response()->json($count);
    }

    public function paidFees($schoolId){
        $count = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('student_profiles.payment_status', 'paid')->count();
        return response()->json($count);
    }

    public function unpaidFees($schoolId){
        $count = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('student_profiles.payment_status', 'not-paid')->count();
        return response()->json($count);
    }

    public function incompleteFees($schoolId){
        $count = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
        ->join('branches', 'users.branchid','branches.id')
        ->where('branches.schoolid', $schoolId)
        ->where('student_profiles.payment_status', 'incomplete')->count();
        return response()->json($count);
    }

    public function classesManaged(){}
    public function studentInClass(){}
    public function maleStudentsInClass(){}
    public function femaleStudentsInClass(){}
}
