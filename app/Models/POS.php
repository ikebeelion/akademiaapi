<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class POS extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = ['productid',
    'orderid',
    'qty',
    'price',
    'status'];

    public function product(){
        return $this->belongsTo(Product::class, 'productid');
    }
}
