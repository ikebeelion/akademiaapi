<?php

namespace App\Http\Controllers;

use App\Actions\NotifyParentSmS;
use App\Models\Parent_Student;
use App\Models\ParentProfile;
use App\Models\Result;
use App\Models\StaffProfile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;

class Sendsms extends Controller
{
    public function sendSms(Request $request, $branchid){
        // send SMS
        $data = $request->all();
        if($data['category'] == 1){
            // parent
            if($data['wardgroup'] == 0){
                $getProfiles = ParentProfile::join('users', 'parent_profiles.useraccountid', 'users.id')
                            ->where('users.branchid', $branchid)->get();
                            $contacttel = [];
                foreach($getProfiles as $profile){
                    // array_push($contacttel, $profile['contacttel'] );
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.ycloud.com/v1/sms/send_messages",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\"mobile\":\"".$profile['contacttel']."\",\"text\":\"".$data['content']."\"}",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                        "X-API-Key: 486d00ff7405ba996754289c1b40a755"
                    ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                    echo $response;
                    }
                }
            }else{
                $getProfiles = Parent_Student::select('parent_profiles.contacttel as parenttel', 'student_profiles.contacttel as wardtel')->join('parent_profiles', 'parent__students.parentid', 'parent_profiles.useraccountid')
                ->join('student_profiles','parent__students.studentid', 'student_profiles.studentuseraccountid')
                ->where('student_profiles.yearid', $data['wardgroup'])->get();

                $contacttel = [];
                foreach($getProfiles as $profile){
                    // array_push($contacttel, $profile['contacttel'] );
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.ycloud.com/v1/sms/send_messages",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\"mobile\":\"".$profile['parenttel']."\",\"text\":\"".$data['content']."\"}",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                        "X-API-Key: 486d00ff7405ba996754289c1b40a755"
                    ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                    echo $response;
                    }
                }
            }
            return response()->json('SENT SUCCESSFULLY');

        }elseif($data['category'] == 2){
            // student
            if($data['group'] == 0){
                $getProfiles = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
                            ->where('users.branchid', $branchid)->get();
            }else{
                $getProfiles = StudentProfile::join('users', 'student_profiles.studentuseraccountid', 'users.id')
                            ->where('users.branchid', $branchid)
                            ->where('yearid', $data['group'])->get();
            }
            $contacttel = [];
            foreach($getProfiles as $profile){
                // array_push($contacttel, $profile['contacttel'] );
                $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.ycloud.com/v1/sms/send_messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"mobile\":\"".$profile['contacttel']."\",\"text\":\"".$data['content']."\"}",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-API-Key: 486d00ff7405ba996754289c1b40a755"
                ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                echo $response;
                }
            }
            return response()->json('SENT SUCCESSFULLY');

        }else{
            // staff
            $getProfiles = StaffProfile::join('users', 'staff_profiles.staffuseraccountid', 'users.id')
                        ->where('users.branchid', $branchid)->get();
            $contacttel = [];
            foreach($getProfiles as $profile){
                $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.ycloud.com/v1/sms/send_messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"mobile\":\"".$profile['contacttel']."\",\"text\":\"".$data['content']."\"}",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-API-Key: 486d00ff7405ba996754289c1b40a755"
                ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                echo $response;
                }
            }
            return response()->json('SENT SUCCESSFULLY');
        }
    }

    public function sendCAsMS(Request $request){
        $data = $request->all();
        // return response()->json($request['period']);
        // get CA of all students in Group ID
        $student_profile = StudentProfile::where('yearid', $data['group'])->get();
        // foreach of them get their CA result for that period
        foreach ($student_profile as $student) {
            $ca = Result::join('subject__class_groups', 'results.subjectid', 'subject__class_groups.id')
            ->join('subjects', 'subject__class_groups.subjectid', 'subjects.id')
            ->join('student_profiles', 'results.studentid', 'student_profiles.studentuseraccountid')
            ->where('academic_periodid', $request['period'])
            ->where('restult_typeid', 1)->where('results.studentid', $student['studentuseraccountid'])
            ->with('student')->get();

            $ca_count = count($ca);
            $arr = [];
            $msg = 'This is the CA for your ward ';
            for ($i=0; $i < $ca_count; $i++) {
                if($i > 0){
                    $message = "SUBJECT:".$ca[$i]['subjecttitle']. ", SCORE:".$ca[$i]['score_obtained']. ",  ";
                    array_push($arr, $message);
                    $msg .= ''.$message;
                }else{
                    $message = "NAME:"." ".$ca[$i]['firstname']. " ".$ca[$i]['lastname']."  SUBJECT:".$ca[$i]['subjecttitle']. ", SCORE:".$ca[$i]['score_obtained'].", ";
                    array_push($arr, $message);
                    $msg .= ''.$message;
                }
            }

            // print_r($msg);

            $getParent = Parent_Student::join('parent_profiles', 'parent__students.parentid', 'parent_profiles.useraccountid')->
            where('studentid', $student['studentuseraccountid'])->first();

            $curl = curl_init();
            $data = array("api_key" => "TLvZziFlOFdB3dqvAhFtspi80IUK6akVm2JgzDxARtfppjrMRXL5I6UI8FZhk7", "to" => $getParent['contacttel'],  "from" => "Akademia",
            "sms" => $msg,  "type" => "plain",  "channel" => "generic" );

            $post_data = json_encode($data);

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;

            return response()->json($response);





            }


    }
}
