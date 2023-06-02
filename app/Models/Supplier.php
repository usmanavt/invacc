<?php

namespace App\Models;

use App\Models\Contract;
use App\Models\Source;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    // public $appends = ['material_title'];




    protected $fillable = ['title',
    'nick','address','phoneoff',
    'phoneres','fax','email','status',
    'obalance','ntn','stax','source_id','status'];


    // public function getMaterialTitleAttribute()
    // {
    //     return $this->source->title;
    // }




    //  Relationships

    // public function getSourceTitleAttribute()
    // {
    //     return $this->source->title;
    // }

    // return $this->commericalInvoiceDetails()->sum('totallccostwexp');


    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // public function source(){ return $this->belongsTo(Source::class); }

    public function source()
    {
        return $this->belongsTo(Source::class,'source_id');
    }








}
