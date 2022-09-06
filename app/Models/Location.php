<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table= "tblelocation";
    protected $fillable = ['locname','locaddress'];

    // Accessors
    public function getLocnameAttribute()
    {
        return ucfirst($this->attributes['locname']);
    }
    //  Mutators
    public function setLocnameAttribute($value)
    {
        $this->attributes['locname'] = ucfirst($value);
    }

    // Relationships
}
