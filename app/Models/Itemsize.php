<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    use HasFactory;
    protected $table= "tblesize";
    protected $fillable = ['sizename','sizenname'];
    
    // Accessors
    public function getSizeNameAttribute()
    {
        return ucfirst($this->attributes['sizename']);
    }
    //  Mutators
    public function setSizeNameAttribute($value)
    {
        $this->attributes['sizename'] = ucfirst($value);
    }

}
