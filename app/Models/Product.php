<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'categoryid',
        'productname',
        'qty',
        'cost_price',
        'selling_price',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'categoryid');
    }
}
