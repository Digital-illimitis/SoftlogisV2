<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamillyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'libelle',
        'description',
        'etat'
    ];
}
