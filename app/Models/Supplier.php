<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $table= "tblesupplier";
    protected $fillable = ['sname',
    'snname','spaddress','sphoneoff',
    'sphoneres','sfax','semail','sstatus',
    'obalance','ntnno','staxNo','srcId'];

    // Accessors
    public function getSNamettribute($value)
    {
        return strtoupper($value);
    }

    //  Relationships
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

}
