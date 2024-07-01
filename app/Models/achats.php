<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achats extends Model
{

  
    public function fournisseur()
    {
        return $this->belongsTo('App\Models\fournisseurs');
    }
 
    protected $fillable = [
        'date',
        'total_ht',
        'total_ttc',
        'fournisseur_id',
    ];

    use HasFactory;

}
