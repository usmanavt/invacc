<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use App\Models\Supplier;
use App\Models\ContractDetails;
use App\Models\CommercialInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    public $dates = ['invoice_date'];
    protected $fillable = ['invoice_date','number','supplier_id','conversion_rate','insurance'];

    protected function serializeDate(DateTimeInterface $date){return $date->format('d-m-Y');}


    // Relationships
    public function supplier(){ return $this->belongsTo(Supplier::class,'supplier_id');}
    public function user(){ return $this->belongsTo(User::class,'user_id');}

    public function contractDetails(){ return $this->hasMany(ContractDetails::class);}
    public function commercialInovices(){ return $this->hasMany(CommercialInvoice::class);}

}
