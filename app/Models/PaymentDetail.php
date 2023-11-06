<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'paymentid','invoice_id','invoice_no','invoice_date','amountrs','amountdlrs'
     ];
}
