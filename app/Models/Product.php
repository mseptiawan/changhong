<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $primaryKey = 'id_product'; // WAJIB
    public $incrementing = false;       // Jika id_spgms adalah string (misalnya 'CEI01')
    protected $keyType = 'string';      // Tipe string jika bukan integer
    public $timestamps = false;

    protected $fillable = [
        'id_product',
        'category_code',
        'sell_out_price',
        'product_name',
        'variant',
        'code_material',
        'bigsize'
    ];


    public function modelIncentives()
    {
        return $this->hasMany(ModelIncentives::class, 'product_id', 'id_product');
    }
    public function sales()
    {
        return $this->hasMany(SalesTransaction::class, 'product_id', 'id_product');
    }


    public function discontinuedProduct()
    {
        return $this->hasOne(DiscontinuedProduct::class, 'product_id', 'id_product');
    }
    public function isDiscontinued()
    {
        return $this->discontinuedProduct !== null;
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_code', 'category_code');
    }
}
