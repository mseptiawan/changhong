<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalIncentive extends Model
{
    //
      protected $table = 'final_incentives';
    protected $guarded = [];



    public function spgm()
    {
        return $this->belongsTo(Spgm::class);
    }
}
