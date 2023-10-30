<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $fillable = ['commercial_invoice_id','prdate','prno','prtwt','prtpcs','prtfeet'];


    public function purchasereturndetail(){return $this->hasMany(PurchaseReturnDetail::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }


}
