<?php

namespace App\Http\Controllers;

use App\Mail\SendPassword;
use App\Models\Attendance;
use App\Models\ClassRoomGroup;
use App\Models\EmploymentHistory;
use App\Models\StaffProfile;
use App\Models\Student_ClassRoomGroup;
use App\Models\StudentProfile;
use App\Models\Subject_ClassGroup;
use App\Models\Subject_Teacher;
use App\Models\Teacher_ClassRoomGroup;
use App\Models\Timetable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring of specified length
        return substr(str_shuffle($str_result),
                        0, $length_of_string);
    }

    public function index($id){
        $staff = StaffProfile::select('staff_profiles.*')
        ->join('users', 'staff_profiles.staffuseraccountid', 'users.id')
        ->with('nationality')->with('stateoforigin')->with('country')->with('state')
        ->with('city')->with('rank')->with('createdBy')
        ->where('users.branchid', $id)->get();

        return response()->json($staff);
    }

    public function updatePassword(Request $request, $id){
        // validate
        $validate = Validator::make([$request->password], ['password'=>'required']);
        if($validate){

            $user = User::where('id', $id)->first();

            if($user){
                $user->password = Hash::make($request->password);
                $user->stringpassword = $request->password;
                $user->save();
                return response()->json(['message'=>'saved', $user->stringpasswrod], );
            }else{
                return response()->json('User does not exist', 400);
            }
        }else{
            return response()->json('Password is required', 400);
        }
    }

    public function store(Request $request){
        $data = $request->all();
        $username = strtolower(substr($data['firstname'], 0,2).substr($data['lastname'],0,2));
        $checkUsername = User::where('username', $username)->first();

        if(! $checkUsername){
            $newUser = new User();
            $newUser->roleid = 3;
            $newUser->username = strtolower(substr($data['firstname'], 0,2).substr($data['lastname'],0,2));
            $pass = Hash::make($this->random_strings(8));
            $newUser->password = $pass;
            $newUser->email = $data['contactemail'];
            $newUser->stringpassword = $this->random_strings(8);
            $newUser->branchid = $data['branchid'];
            $newUser->save();
            // send email


            $staff = new StaffProfile();
            $staff->title = $data['title'];
            $staff->staffuseraccountid = $newUser->id;
            $staff->firstname = $data['firstname'];
            $staff->lastname = $data['lastname'];
            $staff->othernames = $data['othernames'];
            $staff->dob = $data['dob'];
            $staff->genderid = $data['genderid'];
            $staff->religion = $data['religion'];
            $staff->appointment_date = $data['appointment_date'];
            // $staff->classgroups = $data['classgroups'];
            $staff->nationalityid = $data['nationalityid'];
            $staff->stateoforiginid = $data['stateoforiginid'];
            $staff->local_govt_area = $data['local_govt_area'];
            $staff->address = $data['address'];
            $staff->countryid = $data['countryid'];
            $staff->stateid = $data['stateid'];
            $staff->cityid = $data['cityid'];
            $staff->contactemail = $data['contactemail'];
            $staff->contacttel = $data['contacttel'];
            $staff->photo = $data['photo'];
            $staff->rankid = $data['rankid'];
            $staff->staff_type = $data['staff_type'];
            $staff->createdById = auth('sanctum')->user()->id;
            $staff->save();
            if($data['contactemail'] != null){
                try {
                    Mail::to($data['contactemail'])->send(new SendPassword('New Acount Password', $pass));
                    return response()->json('profile created');
                } catch (\Throwable $th) {
                    return response()->json('Coul not send email', 500);
                }
            }else{
                return response()->json('profile created');
            }
        }else{
            $staff = new StaffProfile();
            $staff->title = $data['title'];
            $staff->staffuseraccountid = $checkUsername->id;
            $staff->firstname = $data['firstname'];
            $staff->lastname = $data['lastname'];
            $staff->othernames = $data['othernames'];
            $staff->dob = $data['dob'];
            $staff->genderid = $data['genderid'];
            $staff->religion = $data['religion'];
            $staff->appointment_date = $data['appointment_date'];
            // $staff->classgroups = $data['classgroups'];
            $staff->nationalityid = $data['nationalityid'];
            $staff->stateoforiginid = $data['stateoforiginid'];
            $staff->local_govt_area = $data['local_govt_area'];
            $staff->address = $data['address'];
            $staff->countryid = $data['countryid'];
            $staff->stateid = $data['stateid'];
            $staff->cityid = $data['cityid'];
            $staff->contactemail = $data['contactemail'];
            $staff->contacttel = $data['contacttel'];
            $staff->photo = $data['photo'];
            $staff->rankid = $data['rankid'];
            $staff->staff_type = $data['staff_type'];
            $staff->createdById = auth('sanctum')->user()->id;;
            $staff->save();
        }


    }

public function getSingleStaff($id){
        $staff = StaffProfile::select('staff_profiles.*')
        ->join('users', 'staff_profiles.staffuseraccountid', 'users.id')
        ->where('staff_profiles.id', $id)->get();
        return response()->json($staff);
}
public function updateStaff(Request $request, $id){
    $data = $request->all();
    $staff = StaffProfile::findOrFail($id);

    $staff->title = $data['title'];
    $staff->firstname = $data['firstname'];
    $staff->lastname = $data['lastname'];
    $staff->othernames = $data['othernames'];
    $staff->dob = $data['dob'];
    $staff->genderid = $data['genderid'];
    $staff->religion = $data['religion'];
    $staff->appointment_date = $data['appointment_date'];
    // $staff->classgroups = $data['classgroups'];
    $staff->nationalityid = $data['nationalityid'];
    $staff->stateoforiginid = $data['stateoforiginid'];
    $staff->local_govt_area = $data['local_govt_area'];
    $staff->address = $data['address'];
    $staff->countryid = $data['countryid'];
    $staff->stateid = $data['stateid'];
    $staff->cityid = $data['cityid'];
    $staff->contactemail = $data['contactemail'];
    $staff->contacttel = $data['contacttel'];
    $staff->photo = $data['photo'];
    $staff->rankid = $data['rankid'];
    $staff->staff_type = $data['staff_type'];
    $staff->createdById = auth('sanctum')->user()->id;;
    $staff->save();
    $user = User::findOrFail($staff->staffuseraccountid);
    $user->email = $data['contactemail'];
    $user->save();

    return response()->json('profile updated');

}

public function deleteStaff($id){
    StaffProfile::findOrFail($id)->delete();
    return response()->json('remoeved');
}

public function getSubjectTeacher($id){
    $staffprofile = StaffProfile::where('staffuseraccountid', $id)->get();
    $subjectteacher = DB::table('subject__teachers')->select('subject__teachers.id','subject__teachers.subjectid as sub', 'subjects.subjecttitle', 'subjects.subject_alias', 'class_groups.classgroupname', 'class_groups.id as groupid')
    ->join('subject__class_groups', 'subject__teachers.subjectid', 'subject__class_groups.id')
    ->join('subjects','subject__class_groups.subjectid', 'subjects.id' )
    ->join('class_groups','subject__class_groups.classgroupid', 'class_groups.id' )
    ->where('subject__teachers.tutorid', $id)
    ->where('subject__teachers.deleted_at', null)
    ->get();
    return response()->json($subjectteacher);

}

public function saveSubjectAssign(Request $request){
    $data = $request->all();
    foreach ($data as $data) {
        $subjectTeacher = new Subject_Teacher();
        $subjectTeacher->subjectid = $data['subjectid'];
        $subjectTeacher->tutorid =$data['staffuseraccountid'];
        $subjectTeacher->createdById = auth('sanctum')->user()->id;;
        $subjectTeacher->save();
    }
    return response()->json('saved');
}



    public function deleteSubjectTutor($id){
        Subject_Teacher::findOrFail($id)->delete();

        return response()->json('deleted');
    }
    public function saveclassRoomTeacher(Request $request){
        $data = $request->all();
        foreach ($data as $data) {
            $classroomteacher = new Teacher_ClassRoomGroup();
            $classroomteacher->teacherid = $data['teacherid'];
            $classroomteacher->clsrmgpid =$data['classroomgroupid'];
            $classroomteacher->createdById = auth('sanctum')->user()->id;;
            $classroomteacher->save();
        }
        return response()->json('saved');

    }

    public function getClassRoomTeacher($id){
        $classroomteacher = DB::table('teacher__class_room_groups')->select('teacher__class_room_groups.id', 'teacher__class_room_groups.clsrmgpid','teacher__class_room_groups.teacherid', 'class_rooms.classroom', 'class_groups.classgroupname','class_groups.id as clgid',)
        ->join('class_room_groups', 'teacher__class_room_groups.clsrmgpid', 'class_room_groups.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('teacher__class_room_groups.teacherid', $id)
        ->where('teacher__class_room_groups.deleted_at', null)
        ->get();
        return response()->json($classroomteacher);

    }

    public function getClassRoomTeacherB($id, $classgroupid){
        $classroomteacher = DB::table('teacher__class_room_groups')->select('teacher__class_room_groups.id', 'teacher__class_room_groups.clsrmgpid','teacher__class_room_groups.teacherid', 'class_rooms.classroom', 'class_groups.classgroupname','class_groups.id as clgid',)
        ->join('class_room_groups', 'teacher__class_room_groups.clsrmgpid', 'class_room_groups.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->where('teacher__class_room_groups.teacherid', $id)
        ->where('teacher__class_room_groups.deleted_at', null)
        ->where('class_room_groups.classgroupid', $classgroupid)
        ->get();
        return response()->json($classroomteacher);

    }

    public function deleteClassroomteacher($id){
        Teacher_ClassRoomGroup::findOrFail($id)->delete();
        return response()->json('removed');
    }

    public function allstudentsclass($id){
        $students =  DB::table('student__class_room_groups')->select('student_profiles.id as stid','student_profiles.*', 'class_room_groups.id as clsgpid','class_room_groups.*')
        ->join('student_profiles', 'student__class_room_groups.studentid', 'student_profiles.studentuseraccountid')
        ->join('class_room_groups', 'student__class_room_groups.classroomgroupid', 'class_room_groups.id')
        ->where('classroomgroupid', $id)
        ->where('student__class_room_groups.deleted_at', null)
        ->where('student_profiles.deleted_at', null)
        ->get();

        return response()->json($students);
    }

    public function classgroups($id){
        $groups = ClassRoomGroup::where('classgroupid', $id)->with('classroom')->with('classgroup')->get();
        return response()->json($groups);
    }

    public function saveAttendance(Request $request){
        $data = $request->all();
        $student_attendance = $data[1];
        $classinfo = $data[0];
        foreach($student_attendance as $student_data){
            $attendance = new Attendance();
            $attendance->studentuseraccount = $student_data['studentuseraccount'];
            $attendance->classid = $classinfo['classroom'];
            $attendance->subject = $classinfo['subdetail']['subject'];
            $attendance->status = $student_data['status'];
            $attendance->date = $classinfo['date'];
            $attendance->absentedBy = auth('sanctum')->user()->id;;
            $attendance->save();
        };

        return response()->json('saved');

    }

    public function getAttendance($classroom, $subject, $date){
        $attendance =  DB::table('attendances')->select('*')
                        ->join('student_profiles', 'attendances.studentuseraccount', 'student_profiles.id')
                        ->where('attendances.classid', $classroom)
                        ->where('subject', $subject)
                        ->where('date', $date)
                        ->get();
            return response()->json($attendance);
    }

    public function getSubjectStudents($teacherid){
        //
        // first get the subjects the teacher takes
        $teacher_subjectgroup = Subject_Teacher::select('subjects.*','class_groups.classgroupname','class_groups.id as clgrid','subject__teachers.*', 'subject__class_groups.id as sclid')
                                    ->join('subject__class_groups','subject__teachers.subjectid', 'subject__class_groups.id')
                                    ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                                    ->join('class_groups', 'subject__class_groups.classgroupid','class_groups.id')
                                    ->where('tutorid', $teacherid)->get();
        return response()->json($teacher_subjectgroup);

    }

    public function getStudentsForSubjects($teacherid){

        $teacher_subjectgroup = Subject_Teacher::join('subject__class_groups','subject__teachers.subjectid', 'subject__class_groups.id')
                                    ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
                                    ->join('class_groups', 'subject__class_groups.classgroupid','class_groups.id')
                                    ->where('tutorid', $teacherid)->get();
        $students = [];
        // get students of class group offering that subject
        // foreach($teacher_subjectgroup as $teacher){
            $students_in_groups = StudentProfile::where('yearid', $teacherid)->get();
            array_push($students,$students_in_groups );
        // }
        return response()->json($students_in_groups);
    }

    public function addEmployment(Request $request){
        $employment = new EmploymentHistory();
        $employment->staffid = $request[0];
        $employment->employer = $request[1]['employer'];
        $employment->startdate = $request[1]['startdate'];
        $employment->enddate = $request[1]['enddate'];
        $employment->save();
    }
    public function getEmployment($id){
        $employment = EmploymentHistory::where('staffid', $id)->get();
        return response()->json($employment);
    }

    public function getSingleEmployment($id){
        $employment = EmploymentHistory::where('id', $id)->first();
        return response()->json($employment);
    }

    public function updateEmployment(Request $request, $id){
        $employment = EmploymentHistory::findOrFail($id);
        $employment->employer = $request['employer'];
        $employment->startdate = $request['startdate'];
        $employment->enddate = $request['enddate'];
        $employment->save();
    }

    public function deleteEmployment($id){
        EmploymentHistory::findOrFail($id)->delete();
    }

    public function uploadStaffImage(Request $request){
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/staff'), $fileName);
        return response()->json($fileName);
    }

    public function getTimetable($staffid, $period){
        $subjectteacher = DB::table('subject__teachers')->select('subject__teachers.id','subject__teachers.subjectid as sub', 'subjects.subjecttitle', 'subjects.subject_alias', 'class_groups.classgroupname', 'class_groups.id as groupid')
    ->join('subject__class_groups', 'subject__teachers.subjectid', 'subject__class_groups.id')
    ->join('subjects','subject__class_groups.subjectid', 'subjects.id' )
    ->join('class_groups','subject__class_groups.classgroupid', 'class_groups.id' )
    ->where('subject__teachers.tutorid', $staffid)
    ->where('subject__teachers.deleted_at', null)
    ->get();

    $timetableArray = [];
    foreach ($subjectteacher as $loopval) {
        // get timetable
        $timetable = Timetable::join('subject__class_groups', 'timetables.subjectid', 'subject__class_groups.id')
        ->join('class_room_groups','timetables.classRoomGroupid','class_room_groups.id')
        ->join('class_groups', 'class_room_groups.classgroupid', 'class_groups.id')
        ->join('class_rooms', 'class_room_groups.classroomid', 'class_rooms.id')
        ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
        ->where('timetables.subjectid', $loopval->sub)
        ->where('timetables.academic_periodid', $period)
        ->where('timetables.timetabletype','class_timetable')
        ->where('timetables.status', 'approved')
        ->get();

        array_push($timetableArray, $timetable);
    }

        return response()->json($timetableArray);

    }
}
