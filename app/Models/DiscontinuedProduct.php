<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscontinuedProduct extends Model
{
    protected $table = 'discontinued_products';

    protected $primaryKey = 'id_discontinue'; // karena default-nya 'id'
    public $incrementing = true;              // ID-nya berupa angka auto increment
    protected $keyType = 'int';

    protected $fillable = [
        'product_id',
        'discontinue_date',
    ];

    public $timestamps = false;

    /**
     * Relasi ke produk.
     * DiscontinuedProduct belongsTo Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
}
