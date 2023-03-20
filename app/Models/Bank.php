<?php

namespace App\Models;

use App\Models\BankTransaction;
use App\Models\Clearance;
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
        'status',
        'docdate'
    ];

    /************** Relationships **************/
    public function bankTransactions() { return $this->hasMany(BankTransation::class); }
    public function clearances() { return $this->hasMany(Clearance::class); }
}
