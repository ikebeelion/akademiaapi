<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('country/', function () {
    $country = Country::all();
    return response()->json($country);
});
Route::get('state/', function (){
    $state = State::all();
    return response()->json($state);
});
Route::get('state/{countryid}', function ($countryid) {
    $state = State::where('countryid', $countryid)->get();
    return response()->json($state);
});
Route::get('city/{stateid}', function ($stateid) {
    $city = City::where('stateid', $stateid)->get();
    return response()->json($city);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $userdata = User::where('id', $user->id)->with('branch')->first();
    return response()->json($userdata);
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

// Auth
Route::post('/schregister', [\App\Http\Controllers\Auth\RegisterController::class, 'registerSchool'])->name('registerschool');
Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout',[\App\Http\Controllers\Auth\LoginController::class, 'logout']);
// Priviledges
Route::get('all-priviledges', [\App\Http\Controllers\Priviledge::class, 'priviledges'])->name('priviledges');
Route::post('priviledge', [\App\Http\Controllers\Priviledge::class, 'addPriviledge'])->name('addPriviledge');
Route::delete('delete-priviledge/{id}', [\App\Http\Controllers\Priviledge::class, 'destroy'])->name('destroy');
// Branches
Route::get('branch/{id}', [\App\Http\Controllers\BranchController::class, 'index'])->name('index');
Route::post('branch/store', [\App\Http\Controllers\BranchController::class, 'store'])->name('store');
Route::get('singlebranch/{id}', [\App\Http\Controllers\BranchController::class, 'getSingleBranch'])->name('getSingleBranch');
Route::put('updateBranch/{id}', [\App\Http\Controllers\BranchController::class, 'updateBranch'])->name('updateBranch');
Route::delete('deleteBranch/{id}', [\App\Http\Controllers\BranchController::class, 'deleteBranch'])->name('deleteBranch');
// Class Groups
Route::get('classGroups/{id}', [\App\Http\Controllers\ClassGroupController::class, 'index'])->name('index');
Route::post('classGroups/store', [\App\Http\Controllers\ClassGroupController::class, 'store'])->name('store');
Route::get('singlegroup/{id}', [\App\Http\Controllers\ClassGroupController::class, 'getSingleGroup'])->name('singlegroup');
Route::put('updateGroup/{id}', [\App\Http\Controllers\ClassGroupController::class, 'updateGroup'])->name('updateGroup');
Route::delete('deleteGroup/{id}', [\App\Http\Controllers\ClassGroupController::class, 'deleteGroup'])->name('deleteGroup');
// Class Room
Route::get('classRooms/{id}', [\App\Http\Controllers\ClassRoomController::class, 'index'])->name('index');
Route::post('classRooms/store', [\App\Http\Controllers\ClassRoomController::class, 'store'])->name('store');
Route::get('singleroom/{id}', [\App\Http\Controllers\ClassRoomController::class, 'getSingleRoom'])->name('singleroom');
Route::put('updateRoom/{id}', [\App\Http\Controllers\ClassRoomController::class, 'updateRoom'])->name('updateRoom');
Route::delete('deleteRoom/{id}', [\App\Http\Controllers\ClassRoomController::class, 'deleteRoom'])->name('deleteRoom');
Route::get('yearclassroom/{id}', [\App\Http\Controllers\ClassRoomController::class, 'getYearClassRooms'])->name('getYearClassRooms');
Route::get('studentClassroom/{id}', [\App\Http\Controllers\ClassRoomController::class, 'getStudentClassRoom'])->name('getStudentClassRoom');
// Class Room Groups
Route::get('classRoomGroup/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'index'])->name('index');
Route::get('classrmgroup/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'indexB'])->name('index');
Route::post('classRoomGroup/store', [\App\Http\Controllers\ClassRoomGroupController::class, 'store'])->name('store');
Route::get('singleroomgroup/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'getSingleRoomGroup'])->name('getSingleRoomGroup');
Route::put('updateRoomGroup/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'updateRoomGroup'])->name('updateRoomGroup');
Route::delete('deleteRoomGroup/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'deleteRoomGroup'])->name('deleteRoomGroup');
Route::post('uploadimage', [\App\Http\Controllers\ClassRoomGroupController::class, 'uploadImage'])->name('deleteRoomGroup');
Route::get('studentsinroom/{id}', [\App\Http\Controllers\ClassRoomGroupController::class, 'studentsInClassroom'])->name('studentsInClassroom');
// students
Route::get('all-students/{id}', [\App\Http\Controllers\StudentController::class, 'index'])->name('index');
Route::post('student/store', [\App\Http\Controllers\StudentController::class, 'store'])->name('store');
Route::get('student/{id}', [\App\Http\Controllers\StudentController::class, 'getSingleStudent'])->name('getSingleStudent');
Route::put('student-update/{id}', [\App\Http\Controllers\StudentController::class, 'updateStudent'])->name('updateStudent');
Route::delete('delete-student/{id}', [\App\Http\Controllers\StudentController::class, 'deleteStudent'])->name('deleteStudent');
Route::get('user/{id}', [\App\Http\Controllers\StudentController::class, 'getUser'])->name('getUser');
Route::post('studentclassroom', [\App\Http\Controllers\StudentController::class, 'assignToClassRoom'])->name('assignToClassRoom');
Route::get('get-profile/{id}',  [\App\Http\Controllers\StudentController::class, 'getProfile'])->name('getProfile');
Route::post('studentImage',  [\App\Http\Controllers\StudentController::class, 'studentImage'])->name('studentImage');

// Parents
Route::get('all-parents/{id}', [\App\Http\Controllers\ParentController::class, 'index'])->name('index');
Route::post('parent/store', [\App\Http\Controllers\ParentController::class, 'store'])->name('store');
Route::get('parent/{id}', [\App\Http\Controllers\ParentController::class, 'getSingleParent'])->name('getSingleParent');
Route::put('parent-update/{id}', [\App\Http\Controllers\ParentController::class, 'updateParent'])->name('updateParent');
Route::delete('delete-parent/{id}', [\App\Http\Controllers\ParentController::class, 'deleteParent'])->name('deleteParent');
Route::post('parentImage', [\App\Http\Controllers\ParentController::class, 'parentImage'])->name('parentImage');

//CountryStateCity
Route::post('country/store', [\App\Http\Controllers\CountryStateCityController::class, 'country'])->name('country');
Route::post('state/store', [\App\Http\Controllers\CountryStateCityController::class, 'state'])->name('state');
Route::post('city/store', [\App\Http\Controllers\CountryStateCityController::class, 'city'])->name('city');
// Role
Route::post('role/store', [\App\Http\Controllers\RoleController::class, 'store'])->name('store');
// Ward
Route::post('ward/store', [\App\Http\Controllers\ParentController::class, 'addWard'])->name('addWard');
Route::get('ward/{id}', [\App\Http\Controllers\ParentController::class, 'getWards'])->name('getWards');
Route::put('delete-ward/{id}', [\App\Http\Controllers\ParentController::class, 'deleteParentWard'])->name('deleteParentWard');
// Subject
Route::get('subjects/{id}', [\App\Http\Controllers\SubjectController::class, 'index'])->name('index');
Route::post('subject/store', [\App\Http\Controllers\SubjectController::class, 'store'])->name('store');
Route::get('singlesubject/{id}', [\App\Http\Controllers\SubjectController::class, 'getSingleSubject'])->name('singlesubject');
Route::put('updateSubject/{id}', [\App\Http\Controllers\SubjectController::class, 'updateSubject'])->name('updateSubject');
Route::delete('deleteSubject/{id}', [\App\Http\Controllers\SubjectController::class, 'deleteSubject'])->name('deleteSubject');
// Subject Groups
Route::get('subjectGroup/{id}', [\App\Http\Controllers\SubjectGroupController::class, 'index'])->name('index');
Route::get('subjectGrp/{classid}', [\App\Http\Controllers\SubjectGroupController::class, 'indexB'])->name('index');
Route::get('subjectGrpc/{classid}', [\App\Http\Controllers\SubjectGroupController::class, 'indexC'])->name('index');
Route::get('subjectGrpt/{classid}', [\App\Http\Controllers\SubjectGroupController::class, 'indexD'])->name('index');
Route::get('subjectGrpres/{classgroupid}', [\App\Http\Controllers\SubjectGroupController::class, 'resultIndex'])->name('resultIndex');
Route::post('subjectGroup/store', [\App\Http\Controllers\SubjectGroupController::class, 'store'])->name('store');
Route::get('singlesubjectgroup/{id}', [\App\Http\Controllers\SubjectGroupController::class, 'getSingleSubjectGroup'])->name('singlesubjectgroup');
Route::put('updateSubjectGroup/{id}', [\App\Http\Controllers\SubjectGroupController::class, 'updateSubjectGroup'])->name('updateSubjectGroup');
Route::delete('deleteSubjectGroup/{id}', [\App\Http\Controllers\SubjectGroupController::class, 'deleteSubjectGroup'])->name('deleteRoomGroup');
// school
Route::get('index/{id}', [\App\Http\Controllers\SchoolController::class, 'index'])->name('index');
Route::put('school/{id}', [\App\Http\Controllers\SchoolController::class, 'updateProfile'])->name('updateProfile');
Route::get('principalOfficer/{id}', [\App\Http\Controllers\SchoolController::class, 'principalOfficer'])->name('principalOfficer');
Route::post('submitImage/', [\App\Http\Controllers\SchoolController::class, 'submitImage'])->name('submitImage');
//Rank
Route::get('ranks/{id}', [\App\Http\Controllers\RankController::class, 'index'])->name('index');
Route::post('rank/store', [\App\Http\Controllers\RankController::class, 'store'])->name('store');
Route::get('singlerank/{id}', [\App\Http\Controllers\RankController::class, 'getSingleRank'])->name('singlerank');
Route::put('updateRank/{id}', [\App\Http\Controllers\RankController::class, 'updateRank'])->name('updateRank');
Route::delete('deleteRank/{id}', [\App\Http\Controllers\RankController::class, 'deleteRank'])->name('deleteRank');
// staff
Route::get('all-staff/{id}', [\App\Http\Controllers\StaffController::class, 'index'])->name('index');
Route::post('staff/store', [\App\Http\Controllers\StaffController::class, 'store'])->name('store');
Route::get('staff/{id}', [\App\Http\Controllers\StaffController::class, 'getSingleStaff'])->name('getSingleStaff');
Route::put('staff-update/{id}', [\App\Http\Controllers\StaffController::class, 'updateStaff'])->name('updateStaff');
Route::delete('delete-staff/{id}', [\App\Http\Controllers\StaffController::class, 'deleteStaff'])->name('deleteStaff');
Route::post('savesubjectassign', [\App\Http\Controllers\StaffController::class, 'saveSubjectAssign'])->name('saveSubjectAssign');
Route::get('suject_teacher/{id}',[\App\Http\Controllers\StaffController::class, 'getSubjectTeacher'])->name('getSubjectTeacher');
Route::delete('delete-subjecttutor/{id}',[\App\Http\Controllers\StaffController::class, 'deleteSubjectTutor'])->name('deleteSubjectTutor');
Route::post('saveclassRoomTeacher', [\App\Http\Controllers\StaffController::class, 'saveclassRoomTeacher'])->name('classRoomTeacher');
Route::get('classroom_teacher/{id}',[\App\Http\Controllers\StaffController::class, 'getClassRoomTeacher'])->name('getClassRoomTeacher');
Route::get('classroom_teacher/{id}/{classgroupid}',[\App\Http\Controllers\StaffController::class, 'getClassRoomTeacherB'])->name('getClassRoomTeacherB');
Route::delete('delete-classroomteacher/{id}',[\App\Http\Controllers\StaffController::class, 'deleteClassroomteacher'])->name('deleteClassroomteacher');
Route::get('allstudentsclass/{id}', [\App\Http\Controllers\StaffController::class, 'allstudentsclass'])->name('allstudentsclass');
Route::get('classgroups_group/{id}', [\App\Http\Controllers\StaffController::class, 'classgroups'])->name('classgroups');
Route::post('save_attendance', [\App\Http\Controllers\StaffController::class, 'saveAttendance'])->name('saveAttendance');
Route::get('attendance/{classroom}/{subject}/{date}', [\App\Http\Controllers\StaffController::class, 'getAttendance'])->name('getAttendance');
Route::post('addemployment', [\App\Http\Controllers\StaffController::class, 'addEmployment'])->name('addEmployment');
Route::get('getSingleEmployment/{id}', [\App\Http\Controllers\StaffController::class, 'getSingleEmployment'])->name('getSingleEmployment');
Route::get('emphistory/{id}', [\App\Http\Controllers\StaffController::class, 'getEmployment'])->name('getEmployment');
Route::get('tutortable/{id}/{period}', [\App\Http\Controllers\StaffController::class, 'getTimetable'])->name('getTimetable');
Route::put('updateEmployment/{id}', [\App\Http\Controllers\StaffController::class, 'updateEmployment'])->name('updateEmployment');
Route::delete('deleteEmployment/{id}', [\App\Http\Controllers\StaffController::class, 'deleteEmployment'])->name('deleteEmployment');
Route::post('uploadStaffImage', [\App\Http\Controllers\StaffController::class, 'uploadStaffImage'])->name('uploadStaffImage');

// ASSIGNMENT
Route::post('assignment/store/', [\App\Http\Controllers\AssignmentController::class, 'store'])->name('store');
Route::get('getSingleAssignment/{id}', [\App\Http\Controllers\AssignmentController::class, 'geSingleAssignment'])->name('geSingleAssignment');
Route::get('assignments/{classroom}/{subject}', [\App\Http\Controllers\AssignmentController::class, 'index'])->name('index');
Route::put('updateAssignment/{id}', [\App\Http\Controllers\AssignmentController::class, 'updateAssignment'])->name('updateAssignment');
Route::delete('delete-assignment/{id}', [\App\Http\Controllers\AssignmentController::class, 'deleteAssignment'])->name('deleteAssignment');
Route::post('upload-imageassignment', [\App\Http\Controllers\AssignmentController::class, 'uploadImage'])->name('uploadImage');

// CURRICULAR
Route::post('curricula/store', [\App\Http\Controllers\CurriculaController::class, 'store'])->name('store');
Route::post('curriculadoc', [\App\Http\Controllers\CurriculaController::class, 'curriculadoc'])->name('curriculadoc');

// Academic Timeline
Route::post('year/store', [\App\Http\Controllers\TimelineController::class, 'store_year'])->name('store_year');
Route::post('term/store', [\App\Http\Controllers\TimelineController::class, 'store_term'])->name('store_term');
Route::post('session/store', [\App\Http\Controllers\TimelineController::class, 'store_session'])->name('store_session');
Route::get('academicSessions/{id}', [\App\Http\Controllers\TimelineController::class, 'getSession'])->name('getSession');
Route::get('terms/{id}', [\App\Http\Controllers\TimelineController::class, 'getTerm'])->name('getTerm');
Route::get('academicYears/{id}', [\App\Http\Controllers\TimelineController::class, 'getYear'])->name('getYear');
Route::post('addAcademicPeriod', [\App\Http\Controllers\TimelineController::class, 'addPeriod'])->name('addPeriod');
Route::get('period/{id}', [\App\Http\Controllers\TimelineController::class, 'getPeriod'])->name('getPeriod');
Route::get('activeperiod/{id}', [\App\Http\Controllers\TimelineController::class, 'getActivePeriod'])->name('getActivePeriod');

//Result Type
Route::get('type/{id}', [\App\Http\Controllers\ResultController::class, 'index'])->name('index');
Route::post('type/store', [\App\Http\Controllers\ResultController::class, 'store'])->name('store');
Route::get('singletype/{id}', [\App\Http\Controllers\ResultController::class, 'getSingleType'])->name('singletype');
Route::put('updateType/{id}', [\App\Http\Controllers\ResultController::class, 'updateType'])->name('updateType');
Route::delete('deleteType/{id}', [\App\Http\Controllers\ResultController::class, 'deleteType'])->name('deleteType');
Route::post('score', [\App\Http\Controllers\ResultController::class, 'scoreStudent'])->name('scoreStudent');
Route::get('result/{studentid}/{periodid}/{subjectid}', [\App\Http\Controllers\ResultController::class, 'getResult'])->name('getResult');
Route::get('result/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getPeriodResult'])->name('getPeriodResult');
Route::get('sessionresult/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getSessionResult'])->name('getPeriodResult');
Route::get('scored-students/{periodid}/{subjectid}/{resulttype}', [\App\Http\Controllers\ResultController::class, 'getScoredStudents'])->name('getScoredStudents');
Route::post('storeresult', [\App\Http\Controllers\ResultController::class, 'storeClassResult'])->name('storeClassResult');
Route::get('creditload/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getPeriodResultTotalCredit'])->name('getPeriodResultTotalCredit');
Route::get('points/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getPeriodResultTotalPoints'])->name('getPeriodResultTotalPoints');
Route::get('result-profile/{studentid}/', [\App\Http\Controllers\ResultController::class, 'getResultProfile'])->name('getResultProfile');
Route::post('storepsychmotor',[\App\Http\Controllers\ResultController::class, 'storePsychomotor'])->name('getResultProfile');
Route::put('deletepsychmotor',[\App\Http\Controllers\ResultController::class, 'deletePsychomotor'])->name('getResultProfile');
Route::get('remark/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getRemark'])->name('getRemark');
Route::get('psych/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getPsychomotor'])->name('getPsychomotor');

Route::post('storedomain',[\App\Http\Controllers\ResultController::class, 'storeDomain'])->name('storeDomain');
Route::put('deletedomain',[\App\Http\Controllers\ResultController::class, 'deleteDomain'])->name('deleteDomain');
// Route::get('remark/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getDomainRemark'])->name('getRemark');
Route::get('domain/{studentid}/{periodid}', [\App\Http\Controllers\ResultController::class, 'getDomain'])->name('getDomain');
Route::get('studentscount/{roomgroupid}', [\App\Http\Controllers\ResultController::class, 'getStudentCount'])->name('getStudentCount');

// Psychomotor
Route::get('psychomotors/{id}', [\App\Http\Controllers\PsychomotorController::class, 'index'])->name('index');
Route::post('psychomotors/store', [\App\Http\Controllers\PsychomotorController::class, 'store'])->name('store');
Route::get('singlepsych/{id}', [\App\Http\Controllers\PsychomotorController::class, 'getSinglePsych'])->name('singleroom');
Route::put('updatepsych/{id}', [\App\Http\Controllers\PsychomotorController::class, 'updatePsych'])->name('updateRoom');
Route::delete('deletepsych/{id}', [\App\Http\Controllers\PsychomotorController::class, 'deletePsych'])->name('deleteRoom');

Route::get('domains/{id}', [\App\Http\Controllers\AffectiveDomainController::class, 'index'])->name('index');
Route::post('domains/store', [\App\Http\Controllers\AffectiveDomainController::class, 'store'])->name('store');
Route::get('singledomain/{id}', [\App\Http\Controllers\AffectiveDomainController::class, 'getSingleDomain'])->name('singledomain');
Route::put('updatedomain/{id}', [\App\Http\Controllers\AffectiveDomainController::class, 'updateDomain'])->name('updatedomain');
Route::delete('deletedomain/{id}', [\App\Http\Controllers\AffectiveDomainController::class, 'deleteDomain'])->name('deletedomain');

//storeStudentsComment
Route::post('comment/store', [\App\Http\Controllers\CommentController::class, 'storeComment'])->name('comment-store');
Route::get('comment/{periodid}/{studentid}', [\App\Http\Controllers\CommentController::class, 'index'])->name('comment-index');
Route::put('updatecomment/{id}', [\App\Http\Controllers\CommentController::class, 'updateComment'])->name('comment-update');
Route::delete('comment/delete/{id}', [\App\Http\Controllers\CommentController::class, 'delete'])->name('comment-delete');

// sendSms
Route::post('sms/{branchid}', [\App\Http\Controllers\Sendsms::class, 'sendSms'])->name('sms');
Route::post('casms/{branchid}', [\App\Http\Controllers\Sendsms::class, 'sendCAsMS'])->name('casms');


//getStudentsinYourClassRoom
Route::get('get-students/{teacherid}', [\App\Http\Controllers\StaffController::class, 'getSubjectStudents'])->name('getSubjectStudents');
Route::get('get-students-sub/{teacherid}', [\App\Http\Controllers\StaffController::class, 'getStudentsForSubjects'])->name('getStudentsForSubjects');
Route::put('updatePassword/{id}', [\App\Http\Controllers\StaffController::class, 'updatePassword'])->name('updatePassword');

// Timetable ROute
Route::get('timetable/cr/{branchid}/{classRoomGroupid}', [\App\Http\Controllers\TimeTableController::class, 'classRoomTable'])->name('classRoomTable');
Route::get('timetable/cg/{branchid}/{classGroupId}', [\App\Http\Controllers\TimeTableController::class, 'classGroupTable'])->name('classGroupTable');
Route::post('timetable/store', [\App\Http\Controllers\TimeTableController::class, 'store'])->name('timetablestore');
Route::get('singletable/{id}', [\App\Http\Controllers\TimeTableController::class, 'getSingleTable'])->name('getSingleTable');
Route::put('updatetable/{id}',[\App\Http\Controllers\TimeTableController::class, 'updateTable'])->name('updateTable');
Route::delete('deletetable/{id}', [\App\Http\Controllers\TimeTableController::class, 'deleteTable'])->name('deleteTable');
Route::get('examtimetable/{classgroup}/{period}', [\App\Http\Controllers\TimeTableController::class, 'getExamTimeTable'])->name('getExamTimeTable');
Route::get('classtimetable/{classroom}/{period}', [\App\Http\Controllers\TimeTableController::class, 'getClassTimeTable'])->name('getClassTimeTable');
//TimeTable
Route::get('gettable/{branchid}', [\App\Http\Controllers\TimeTableController::class, 'getTable'])->name('getClassTimeTable');
Route::put('approvetable/{id}', [\App\Http\Controllers\TimeTableController::class, 'approveTable'])->name('approveTable');
Route::put('disapprovetable/{id}', [\App\Http\Controllers\TimeTableController::class, 'disapproveTable'])->name('disapproveTable');

// dashboard
Route::get('getstudentcount/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getStudentCount'])->name('getStudentCount');
Route::get('getstaffcount/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getStaffCount'])->name('getStaffCount');
Route::get('getmalestudents/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getMaleStudents'])->name('getMaleStudents');
Route::get('getfemalestudents/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getFemaleStudents'])->name('getFemaleStudents');
Route::get('getteachingstaff/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getTeachingStaffCount'])->name('getTeachingStaff');
Route::get('getnonteachingstaff/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'getNonTeachingStaffCount'])->name('getNonTeachingStaff');
Route::get('paidfees/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'paidFees'])->name('paidFees');
Route::get('unpaidfees/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'unpaidFees'])->name('unpaidFees');
Route::get('incompletefees/{schoolid}', [\App\Http\Controllers\DashboardController::class, 'incompleteFees'])->name('incompleteFees');

Route::post('promote', [\App\Http\Controllers\Promotition::class, 'promote'])->name('promote');









