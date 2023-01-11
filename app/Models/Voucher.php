<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $dates = ['document_date'];
    protected $fillable = [
        'document_date','transaction_type','head_id','subhead_id','jvno','amount','description'
    ];
}
