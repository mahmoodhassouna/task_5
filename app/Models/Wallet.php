<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];


    public function bank(){
        return $this->belongsTo( Banks::class, 'banks_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
