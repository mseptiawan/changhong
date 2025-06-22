<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
       protected $table = 'companies';
    protected $guarded = [];
    protected $primaryKey = 'id_companies';
    public $incrementing = false;
    protected $keyType = 'string';

    // Company.php
    public function spgms()
    {
        return $this->hasMany(Spgm::class, 'spgms_id', 'id_spgms');
    }
}
