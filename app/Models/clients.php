<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class clients extends Model
{
    use HasFactory , Notifiable;

    protected $fillable = [
        'cin',
        'nom',
        'prenom',
        'telephone',
        'adresse',
        'email',
        'image',
      ];

}
