<?php

namespace App\Models;
use App\Models\Customers;
use App\Models\Sku;
use App\Models\SaleInvoicesDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepasse extends Model
{
    use HasFactory;
    // protected $dates = ['saldate','gpdate'];
    protected $fillable = [
        'sale_invoice_id','saldate','dcno','billno','customer_id','gpseqid','gpdate',
        'gpinvsno','gptotpcs','gptotwt','gptotfeet','status','closed'
                          ];



    //  protected function serializeDate(DateInterface $date){return $date->format('d-m-Y');}
    public function gatepassedetails(){return $this->hasMany(GatepasseDetails::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }

}
