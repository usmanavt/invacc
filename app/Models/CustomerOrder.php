<?php

namespace App\Models;

use DateTimeInterface;
// use App\Models\Contract;
use App\Models\Customers;
use App\Models\Sku;
use App\Models\QuotationDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $dates = ['deliverydt','podate'];
    protected $fillable = [
        'customer_id','deliverydt','poseqno','pono','discntper','discntamt','cartage','rcvblamount','saletaxper'
        ,'saletaxamt','totrcvbamount','Remarks','podate'
    ];
    // public $appends = ['full_total'] ;

    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}
    public function customerorderdetails(){return $this->hasMany(CustomerOrderDetails::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }

}
