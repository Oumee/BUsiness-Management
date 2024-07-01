<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_ventes extends Model
{


    public function vente()
    {
        return $this->belongsTo('App\Models\ventes');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\products');
    }
     
    use HasFactory;


    protected $fillable = [
      'vente_id',
      'product_id',
      'prix_vente',
      'quantite'
    ];
}
