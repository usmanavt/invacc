<?php

namespace App\Models;

use DateTimeInterface;
// use App\Models\Contract;
use App\Models\Customers;
use App\Models\Sku;
use App\Models\SaleInvoicesDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GodownMovement extends Model
{
    use HasFactory;
    // protected $dates = ['saldate','podate'];
    protected $fillable = [
    'stodate','stono','fromg','tog','tqtywt','tqtypcs','tqtyfeet','bqtywt','bqtypcs','bqtyfeet','goodsval'
    ];
    // public $appends = ['full_total'] ;

    // protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}
    public function saleInvoicesdetails(){return $this->hasMany(SaleInvoicesDetails::class); }
    public function customer(){ return $this->belongsTo(Customer::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }

}
