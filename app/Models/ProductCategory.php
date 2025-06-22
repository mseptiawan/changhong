<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    protected $primaryKey = 'category_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['category_code', 'name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_code', 'category_code');
    }
}
