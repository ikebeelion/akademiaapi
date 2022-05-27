<?php

namespace App\Http\Controllers;

use App\Mail\SendPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring of specified length
        return substr(str_shuffle($str_result),
                        0, $length_of_string);
    }

    public function reset_password(Request $request){
        $email = $request['email'];
        $pass = $this->random_strings(8);

        $user = User::where('email', $email)->first();
        if($user){
            $user->password = Hash::make($pass);
            $user->stringpassword = $pass;
            $user->save();

            // email password
            try {
                Mail::to($email)->send(new SendPassword('Password Reset', $pass));
                return response()->json(['message'=>'Check email for new password'], 200);
            } catch (\Throwable $th) {
                return response()->json(['message'=>'Could not send email'], 500);
            }
        }else{
            return response()->json(['message'=>'Email does not exist'], 500);
        }

    }
}
