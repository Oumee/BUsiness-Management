<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class factures extends Model
{
    use SoftDeletes, HasFactory;

    public function vente()
    {
        return $this->belongsTo('App\Models\ventes');
    }
  
    public function entreprise()
    {
        return $this->belongsTo('App\Models\entreprises');
    }
    
    protected $fillable = [
        'numero',
        'date_emission',
        'date_echeance',
        'status',
        'vente_id',
        'entreprise_id',
        'total_facture'
    ];
}
