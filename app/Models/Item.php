<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Source;
use App\Models\Category;
use App\Models\ItemSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $table= "tbleItem";
    protected $fillable = ['category_id','item_size_id','source_id','unit_id','brand_id','iname','inname'];

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
    public function unit(){ return $this->belongsTo(Unit::class); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function brand(){ return $this->belongsTo(Brand::class); }
    public function source(){ return $this->belongsTo(Source::class); }
    public function itemSize(){ return $this->belongsTo(ItemSize::class); }
}
