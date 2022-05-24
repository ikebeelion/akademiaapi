<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Expenditure extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = ['expenditure','exptypeid','cost'];

    public function exptype(){
        return $this->belongsTo(ExpenditureType::class, 'exptypeid');
    }
}
