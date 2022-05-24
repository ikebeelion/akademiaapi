<?php

namespace App\Http\Controllers;

use App\Http\Services\Promotion;
use Illuminate\Http\Request;

class Promotition extends Controller
{
    //see promotions
    // promote
    public function promote(Request $request, Promotion $promotion){
        //
        $promote = $promotion->promote($request);
        return response()->json($promote);
    }
    // update
}
