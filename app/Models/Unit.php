<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Unit model
class Unit extends Model
{
    use HasFactory;
    protected $table= "tbleunit";
    protected $fillable = ['unitname'];

    // Accessors
    public function getUnitNameAttribute()
    {
        return ucfirst($this->attributes['unitname']);
    }
    //  Mutators
    public function setUnitNameAttribute($value)
    {
        $this->attributes['unitname'] = ucfirst($value);
    }

    // Relationships
    public function items(){ return $this->hasMany(Item::class); }
}
