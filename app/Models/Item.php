<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $table= "tbleItem";
    protected $fillable = ['iname','inname'];

    // Accessors
    public function getInameAttribute()
    {
        return ucfirst($this->attributes['iname']);
    }
    //  Mutators
    public function setInameAttribute($value)
    {
        $this->attributes['iname'] = ucfirst($value);
    }

    //  Relationships
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'tbleobszws');
    }
    public function categories(){
        return $this->belongsToMany(Category::class,'tbleobszws'); // 'type' is from pivot table user_role
    }
}
