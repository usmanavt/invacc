<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name',
    'nikc','address','phoneoff',
    'phoneres','fax','email','status',
    'obalance','ntn','stax','source_id','status'];

    //  Relationships
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
 
    public function source(){ return $this->belongsTo(Source::class); }

}
