<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Remark extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['studentid',
    'academic_periodid',
    'teacher_remark',
    'principal_remark',
    'createdBy'];

    public function student(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'academic_periodid');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'createdBy');
    }

}
