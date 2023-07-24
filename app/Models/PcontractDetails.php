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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcontractDetails extends Model
{
    use HasFactory;

    protected $appends = ['ttpcs','gdspricetot','gdspricedtytot','mastertotal'];


    protected $table= "pcontract_details";
    protected $fillable = ['contract_id' ,	'commercial_invoice_id' ,'material_id' ,'user_id' ,'bundle1' ,
	'pcspbundle1', 	'bundle2' ,	'pcspbundle2','gdswt' ,	'gdsprice','status' ,'closed' ,	'purval' ,	'totpcs'];






    public function getTtpcsAttribute()
    {

        $calc = ( $this->bundle1 * $this->pcspbundle1 )+( $this->bundle2 * $this->pcspbundle2 ) ;
        return $calc;

    }


    public function getMastertotalAttribute()
    {

        $calc = ( PcontractDetails::where('id',$this->id)->get());
            return $calc;

    }

    public function getGdspricetotAttribute()
    {


        $calc = $this->gdswt * $this->gdsprice ;
        return $calc;

    }

    public function getGdspricedtytotAttribute()
    {


        $calc = $this->gdswt * $this->gdsprice ;
        return $calc;

    }




    public function pcontract(){ return $this->belongsTo(Contract::class); }
    public function supplier(){ return $this->belongsTo(Supplier::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }
    public function dimension(){ return $this->belongsTo(Dimension::class); }
    public function source(){ return $this->belongsTo(Source::class); }
    public function brand(){ return $this->belongsTo(Brand::class); }
    public function material(){ return $this->belongsTo(Material::class); }

}





