<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class ExpenditureType extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = ['exp_type','branchid'];

    public function branch(){
        return $this->belongsTo(Branch::class, 'branchid');
    }
}
