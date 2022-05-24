<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class AffectiveDomain extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['studentid',
    'academic_periodid',
    'affective_domainid',
    'rating',
    'createdBy'];

    public function student(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'academic_periodid');
    }

    public function affective_domain(){
        return $this->belongsTo(AffectiveDomainTypes::class, 'affective_domainid');
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'createdBy');
    }
}
