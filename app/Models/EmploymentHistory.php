<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class EmploymentHistory extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;
    protected $fillable = [
        'staffid',
        'employer',
        'startdate',
        'enddate'
    ];

    public function staffid(){
        return $this->belongsTo(User::class, 'staffid');
    }


}
