<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    
    protected $guarded = [];
   
    public function section()
    {
        return $this->belongsTo('App\Models\classes');
    }
     
    protected $fillable = [
        'reference',
        'designation',
        'codebare',
        'prix_achat',
        'prix_vente',
        'quantite',
        'image',
        'section_id'
     ];
}
