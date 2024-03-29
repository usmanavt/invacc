<?php

namespace App\Models;
use App\Models\Bank;
use App\Models\Base;
use App\Models\Head;
use App\Models\Subhead;
use App\Models\Customer;
use App\Models\Supplier;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeTransaction extends Model
{
    use HasFactory;
    public $filable=[
        'bank_id',
        'head_id',
        'subhead_id',
        'supplier_id',
        'customer_id',
        'transaction_type',
        'received',
        'payment',
        'cheque_date',
        'cheque_no',
        'descripton',
        'status',
        'documentdate',
        'clrstatus',
        'clrid',
        'clrdate'
    ];
    /************** Relationships **************/
    public function bank(){ return $this->belongsTo(Bank::class); }
    public function head(){ return $this->belongsTo(Head::class); }
    public function subhead(){ return $this->belongsTo(Subhead::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }

}
