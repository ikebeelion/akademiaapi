<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = [
        'paymenttypeid',
        'mathodid',
        'studentID',
        'approval_status',
        'approvedBy',
        'ref_no',
        'classgroupid',
        'period_id',
    ];


    protected $hidden = [
    ];

    // Model relationships
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttypeid');
    }
    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'mathodid');
    }
    public function student()
    {
        return $this->belongsTo(Users::class, 'studentID');
    }
    public function approvedBy()
    {
        return $this->belongsTo(Users::class, 'approvedBy');
    }

    public function classgroup(){
        return $this->belongsTo(ClassGroup::class, 'classgroupid');
    }
    public function period(){
        return $this->belongsTo(Term_Session_Year::class, 'periodid');
    }
}
