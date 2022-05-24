<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Assignment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $fillable = [
        'subjectid',
        'description',
        'classid',
        'submission_date',
        'image',
        'createdBy',
    ];


    protected $hidden = [
    ];

    // Model relationships
    public function subject()
    {
        return $this->belongsTo(Subject_ClassGroup::class, 'subject', 'id');
    }
    public function classRoom()
    {
        return $this->belongsTo(ClassRoomGroup::class, 'classid', 'id');
    }
    public function user()
    {
    return $this->belongsTo(User::class, 'createdBy', 'id');
    }
}
