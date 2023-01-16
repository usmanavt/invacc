<?php

namespace App\Models;

use App\Models\Base;
use App\Models\Head;
use App\Models\Subhead;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Base
{
    use HasFactory;
    protected $dates = ['document_date'];
    protected $fillable = [
        'transaction',
        'document_date','transaction_type','head_id','subhead_id','supplier_id','customer_id','jvno','amount','description'
    ];
    /************** Methods **************/
    public static function generateUniqueTransaction()
    {
        //  Get The Prefix
        $row = Voucher::latest('transaction')->first();
        //  if Not Empty, Invcrement the ID - uses separation via plant_id
        if($row != null)
        {
            $input = $row->transaction;
            $input++;
            return  $input;
        }
        //  If Empty, Create New One - Separate for Both Plants
        return '1000000000000000';
    }
    /************** Relationships **************/
    public function head(){ return $this->belongsTo(Head::class); }
    public function subhead(){ return $this->belongsTo(Subhead::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
}
