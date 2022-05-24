<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class AttendanceCount extends Model
{
    use HasFactory, SoftDeletes, SanctumHasApiTokens;

    protected $fillable =[ 'studentid', 'classid', 'subjectid', 'periodid', 'count_attendance', 'no_of_classes', 'tutor'];

    public function student(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function classroom(){
        return $this->belongsTo(ClassRoomGroup::class, 'classid');
    }

    public function subject(){
        return $this->belongsTo(Subject_ClassGroup::class, 'subjectid');
    }

    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'periodid');
    }

    public function tutor(){
        return $this->belongsTo(User::class, 'tutor');
    }
}
