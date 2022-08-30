<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractDetails extends Model
{
    use HasFactory;
    // protected $dates = false;
    // protected $primaryKey = 'invid';
    // public $incrementing = false; // If no autoincrement
    protected $table= "tblecontracttrans";
    protected $fillable = ['tblecontractmaster_id','transid','brandid','bundle1','pcspbundle1','bundle2','pcspbundle2','gdswt','gdsprice'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    
}
