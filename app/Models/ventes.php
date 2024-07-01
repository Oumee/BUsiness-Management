<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventes extends Model
{

     
    public function client()
    {
        return $this->belongsTo('App\Models\clients');
    }
  
    public function product()
    {
        return $this->belongsTo('App\Models\products');
    }
    
    
    use HasFactory;

    protected $fillable = [
        'date',
        'total_ht',
        'total_ttc',
        'client_id',
    ];
}
