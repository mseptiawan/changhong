<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    //
      protected $table = 'sales_transactions';
    protected $guarded = [];


    public function spgm()
    {
        return $this->belongsTo(Spgm::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
