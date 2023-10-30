<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Godownpr extends Model
{
    use HasFactory;
    protected $fillable = [
        'cominvid','contract_id','contract_date','supplier_id','purinvdt','purinvsno','gpno','gpdate',
        'purtotpcs','purtotwt','purtotfeet' ];

    // public function PurchasingDetails(){return $this->hasMany(PurchasingDetails::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    // public function contract(){ return $this->belongsTo(Contract::class); }
}
