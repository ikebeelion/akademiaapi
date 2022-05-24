<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>['required']
        ]);


        $user = User::where('username', $request->input('username'))->first();
            if(! $user || ! Hash::check($request->input('password'), $user->password)){
                throw ValidationException::withMessages(['The provided credentials are incorrect']);
            }else{

                if($user['roleid'] == 4){
                    // checkFees Status
                    $checkFee =  StudentProfile::where('studentuseraccountid', $user['id'])
                                                ->whereIn('payment_status', ['not-paid','incomplete'])
                                                ->first();
                    if($checkFee){
                        throw ValidationException::withMessages(['Student have fees outstanding']);
                    }else{
                        $token = $user->createToken($request->input('username'))->plainTextToken;
                        return response()->json([
                            'access_token'=> $token,
                            'token_type' => 'Bearer'
                        ]);
                    }

                }else{
                    $token = $user->createToken($request->input('username'))->plainTextToken;
                    return response()->json([
                            'access_token'=> $token,
                            'token_type' => 'Bearer'
                        ]);
                }
            }




    }

    public function logout(){
        Auth::logout();
    }
}
