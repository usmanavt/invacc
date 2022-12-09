<?php

namespace App\Models;

use App\Models\BankTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    public $filable=[
        'title',
        'nick',
        'account_no',
        'branch',
        'address',
        'balance',
        'status'
    ];

    /************** Relationships **************/
    public function bankTransactions() { return $this->hasMany(BankTransation::class); }
}
