<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction_achats extends Model
{
    public function achat()
    {
        return $this->belongsTo('App\Models\achats');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\products');
    }
     
    use HasFactory;


    protected $fillable = [
      'achat_id',
      'product_id',
      'prix_achat',
      'quantite'
    ];
    use HasFactory;
}
