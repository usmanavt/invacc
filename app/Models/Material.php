<?php

namespace App\Models;

use App\Models\Sku;
use App\Models\Brand;
use App\Models\Hscode;
use App\Models\Source;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Dimension;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','dimension_id','source_id','sku_id','brand_id','hscode_id','category','dimension','source','sku','brand','title','nick','status'];

    //  Relationships
    public function dimension(){ return $this->belongsTo(Dimension::class , 'dimension_id'); }
    public function category(){ return $this->belongsTo(Category::class, 'category_id'); }
    public function brand(){ return $this->belongsTo(Brand::class , 'brand_id'); }
    public function source(){ return $this->belongsTo(Source::class , 'source_id'); }
    public function sku(){ return $this->belongsTo(Sku::class, 'sku_id'); }
    public function hscodes(){ return $this->belongsTo(Hscode::class, 'hscode_id'); }

    public function contracts(){ return $this->hasMany(Contract::class); }
    public function quotations(){ return $this->hasMany(Quotation::class); }


}
