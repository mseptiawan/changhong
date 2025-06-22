<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['month'];
    protected $casts = [
        'month' => 'date',
    ];
    protected $fillable = ['spgms_id', 'month', 'target_amount', 'target_bigsize', 'share_bigsize_percent'];

    public function spgm()
    {
        return $this->belongsTo(Spgm::class, 'spgms_id', 'id_spgms');
    }
}
