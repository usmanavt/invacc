<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

     //  Relationships
     public function items(){ return $this->hasMany(Item::class); }

}
