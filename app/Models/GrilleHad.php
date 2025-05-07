<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrilleHad extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'libelle', 'etat', 'code'];
}
