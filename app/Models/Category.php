<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table= "tbleItem0";
    protected $fillable = ['group','groupN'];
    
    // Map Field Alias - for easy access
    protected $map = [
        'group' => 'iname0',
        'groupNick' => 'inname0'
    ];
    protected $hidden = ['iname0','inname0']; // Hide Old Fileds
    protected $appends = ['group','groupNick']; // Now show new fields

    // Accessors
    public function getGroupAttribute()
    {
        return ucfirst($this->attributes['iname0']);
    }
    public function getGroupNickAttribute()
    {
        return ucfirst($this->attributes['inname0']);
    }
    //  Mutators
    public function setIname0Attribute($value)
    {
        $this->attributes['iname0'] = ucfirst($value);
    }
    public function setInname0Attribute($value)
    {
        $this->attributes['inname0'] = ucfirst($value);
    }

    //  Relationships
    public function items(){ return $this->hasMany(Item::class); }
    
}
