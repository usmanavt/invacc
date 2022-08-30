<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\ContractDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    // protected $dates = false;
    // protected $primaryKey = 'invid';
    // public $incrementing = false; // If no autoincrement
    protected $table= "tblecontractmaster";
    protected $fillable = ['invdate','invno','supplier_id'];

    // Accessors
    public function getInvnoAttribute($value)
    {
        return strtoupper($value);
    }


    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }   
    public function contractDetails()
    {
        return $this->hasMany(ContractDetails::class,'tblecontractmaster_id','id');
    }
    
}
