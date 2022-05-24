<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Psychomotor extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['studentid',
    'academic_periodid',
    'psychomotorid',
    'rating',
    'createdBy'];

    public function student(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'academic_periodid');
    }

    public function psychomotor(){
        return $this->belongsTo(Psychomotor_type::class, 'psychomotorid');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'createdBy');
    }
}
