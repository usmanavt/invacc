<?php

namespace App\Models;

use App\Models\Sku;
use App\Models\User;
use App\Models\Brand;
use App\Models\Source;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Dimension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractDetails extends Model
{
    use HasFactory;
    // protected $dates = false;
    // protected $primaryKey = 'invid';
    // public $incrementing = false; // If no autoincrement
    protected $table= "contract_details";
    protected $fillable = ['contract_id','material_id','material_title','supplier_id','user_id','category_id','sku_id','dimension_id','source_id','brand_id','bundle1','pcspbundle1','bundle2','pcspbundle2','gdswt','gdsprice','category','sku','dimension','source','brand'];

    public function contract(){ return $this->belongsTo(Contract::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }
    public function dimension(){ return $this->belongsTo(Dimension::class); }
    public function source(){ return $this->belongsTo(Source::class); }
    public function brand(){ return $this->belongsTo(Brand::class); }
    public function material(){ return $this->belongsTo(Material::class); }

}
