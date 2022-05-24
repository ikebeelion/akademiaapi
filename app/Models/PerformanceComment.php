<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class PerformanceComment extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['studentid',
    'academic_periodid',
    'subjectid',
    'teacher_remark',
    'createdBy',
    'ca',
    'exam',
    'score',
    'avg'
];


    public function student(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'academic_periodid');
    }
    public function subject(){
        return $this->belongsTo(Subject_ClassGroup::class, 'subjectid');
    }
    public function createdBy(){
        return $this->belongsTo(User::class, 'createdBy');
    }

}
