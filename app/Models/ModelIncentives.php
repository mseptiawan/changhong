<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelIncentives extends Model
{
    protected $table = 'model_incentives';
    protected $primaryKey = 'id_model_incentives';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'base_incentive',
        'additional_reward',
        'min_qty_for_reward',
        'effective_start',
        'effective_end',
    ];

    public function ModelIncentives()
    {
        return $this->hasMany(ModelIncentives::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
}
