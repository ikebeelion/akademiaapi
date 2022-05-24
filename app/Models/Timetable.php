<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Timetable extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;
    protected $fillable = [
        'classGroupId',
        'timetabletype',
        'subjectid',
        'from',
        'to',
        'day',
        'createdById',
        'branchid',
        'academic_periodid',
        'status',
        'date'
    ];

    public function classRoomGroup(){
        return $this->belongsTo(ClassRoomGroup::class, 'classRoomGroupid');
    }

    public function classGroup(){
        return $this->belongsTo(ClassGroup::class, 'classGroupId');
    }

    public function academicYear(){
        return $this->belongsTo(Term_Session_Year::class, 'academic_periodid');
    }
    public function subject(){
        return $this->belongsTo(Subject_ClassGroup::class, 'subjectid');
    }

    public function branchid(){
        return $this->belongsTo(Branch::class, 'branchid');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'createById');
    }
}
