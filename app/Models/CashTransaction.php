<?php

namespace App\Models;

use App\Models\Head;
use App\Models\Subhead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;
    protected $dates = ['docdate'];
    public $filable=[
        // 'bank_id',
        'head_id',
        'subhead_id',
         'supplier_id',
         'customer_id',
        'transaction_type',
        'conversion_rate',
        'amount_fc',
        'amount_pkr',
        'docdate',
        'receiver',
        'descripton',
        'status'
    ];
    /************** Relationships **************/
    //public function bank(){ return $this->belongsTo(Bank::class); }
    public function head(){ return $this->belongsTo(Head::class); }
    public function subhead(){ return $this->belongsTo(Subhead::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
}
