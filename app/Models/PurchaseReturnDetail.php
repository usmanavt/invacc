<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    use HasFactory;
    protected $fillable = ['material_id','prunitid','prwt','prpcs','prfeet','prprice','pramount'];
}
