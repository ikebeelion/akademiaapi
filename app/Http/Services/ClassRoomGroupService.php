<?php

namespace App\Http\Services;

use App\Models\StudentProfile;

class ClassRoomGroupService{
    public function studentsInClassroom(int $id){
        $students = StudentProfile::where('classid', $id)->get();
        return ($students);
    }
}
