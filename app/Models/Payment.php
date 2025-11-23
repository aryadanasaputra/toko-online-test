<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id','status','file_path','verified_by','note'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function verifier(){ return $this->belongsTo(User::class, 'verified_by'); }
}
