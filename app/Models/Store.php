<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
      protected $table = 'stores';
    protected $guarded = [];
    protected $primaryKey = 'id_store'; // ⬅️ ini penting
    public $incrementing = false;       // jika key-nya bukan auto-increment (string misalnya)
    protected $keyType = 'string';      // jika id_store bertipe string


    public function spgms()
    {
        return $this->hasMany(Spgm::class, 'spgms_id', 'id_spgms');
    }


    public function sales()
    {
        return $this->hasMany(SalesTransaction::class);
    }
}
