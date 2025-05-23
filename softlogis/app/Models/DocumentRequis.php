<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequis extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'libelle',
        'etat',
        'description',
    ];
}
