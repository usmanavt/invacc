<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    //  Relationships
    public function items(){ return $this->hasMany(Item::class); }
}
