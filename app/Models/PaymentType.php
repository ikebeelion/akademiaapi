<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class PaymentType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = [
        'paymenttype',
        'branchid',
        'createdById',
        'periodid'
    ];


    protected $hidden = [
    ];

    // Model relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branchid', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdById', 'id');
    }
    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'periodid');
    }
}
