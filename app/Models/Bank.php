<?php

namespace App\Models;

use App\Models\BankPayments;
use App\Models\BankTransactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    public $filable=[
        'bank',
        'nick',
        'account_no',
        'branch',
        'address',
        'balance',
        'status'
    ];

    /************** Relationships **************/
    public function bankTransactions(){ return $this->belongsTo(BankTransactions::class); }
}
