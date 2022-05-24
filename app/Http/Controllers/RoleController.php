<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /*
        ROLES
        1. Super Admin
        2. Admin
        3. Staff
        4. Student
        5. Parent
        SAY CHEEZE!!
     */
    public function index(){
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request){
        $data = $request->all();
        // dd($data);
        $role = new Role();
        $role->roles = $data['role'];
        $role->save();
        return response()->json('Role Added');
    }

    public function deleteRole($id){
        Role::findOrFail($id)->delete();
    }
}
