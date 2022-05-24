<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Promote extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes, Notifiable;
    protected $fillable = [
        'studentid',
        'promoted_from',
        'promoted_to',
        'date',
        'promotedBy'
    ];

    public function studentid(){
        return $this->belongsTo(User::class, 'studentid');
    }

    public function promotedFrom(){
        return $this->belongsTo(ClassRoomGroup::class, 'promoted_from');
    }

    public function promotedTo(){
        return $this->belongsTo(ClassRoomGroup::class, 'promoted_to');
    }

    public function promotedBy(){
        return $this->belongsTo(User::class, 'promotedBy');
    }
}
