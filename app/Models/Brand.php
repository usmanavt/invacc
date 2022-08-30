<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table= "tblebrand";
    protected $fillable = ['brandname','sstatus'];

    // Accessors
    public function getBrandNamettribute($value)
    {
        return strtoupper($value);
    }
    //  Mutators
    public function getBrandNameAttribute()
    {
        return ucfirst($this->attributes['brandname']);
    }
}
