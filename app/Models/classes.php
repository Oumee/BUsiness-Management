<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'description',
        'image',
        'Created_by'
    ];



    
}
