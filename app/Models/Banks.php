<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;

    protected $table= 'banks';
    public $timestamps = true;
    protected $guarded = [];

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }
}
