<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $table= "tbleobszws";
    protected $fillable = ['category_id','item_id','itmsizeid','obqty','purrate','costrate',
    'srcid','purunitid','trid','locid','brandid','sstatus'];

    //  Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tbleobszws','id','category_id');
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'tbleobszws','id','item_id');
    }
}
