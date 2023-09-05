<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class OpeningGodownStock extends Model
{
    use HasFactory;
    protected $fillable = [
    'opdate','ostkwte13','ostkpcse13','ostkfeete13','ostkwtgn2','ostkpcsgn2', 'ostkfeetgn2','ostkwtams','ostkpcsams','ostkfeetams',
    'ostkwte24','ostkpcse24','ostkfeete24','ostkwtbs','ostkpcsbs','ostkfeetbs','ostkwtoth',
    'ostkpcsoth','ostkfeetoth','ostkwttot','ostkpcstot', 'ostkfeettot', 'ocostwt','ocostpcs', 'ocostfeet',
    ];





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
