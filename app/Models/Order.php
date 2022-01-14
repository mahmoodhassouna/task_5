<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
