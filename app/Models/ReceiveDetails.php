<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'receivedid','invoice_id','billno','dcno','dcamount','staxper','staxamount','invoice_bal'
     ];

}
