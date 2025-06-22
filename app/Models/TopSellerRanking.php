<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopSellerRanking extends Model
{
    //
     protected $table = 'top_seller_rankings';

    protected $guarded = [];


    public function spgm()
    {
        return $this->belongsTo(Spgm::class);
    }
}
