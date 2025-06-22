<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spgm extends Model
{
    //
    protected $table = 'spgms';
    protected $primaryKey = 'id_spgms'; // WAJIB
    public $incrementing = false;       // Jika id_spgms adalah string (misalnya 'CEI01')
    protected $keyType = 'string';      // Tipe string jika bukan integer
    public $timestamps = false;

    protected $guarded = [];

    public function store()
    {

        return $this->belongsTo(Store::class, 'store_id', 'id_store');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id_companies');
    }
    public function finalIncentives()

    {
        return $this->hasMany(FinalIncentive::class);
    }
    public function sales()
    {
        return $this->hasMany(SalesTransaction::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class, 'spgms_id', 'id_spgms');
    }

    public function topSellerRankings()
    {
        return $this->hasMany(TopSellerRanking::class);
    }
}
