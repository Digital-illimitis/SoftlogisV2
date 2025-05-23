<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;
    protected $fillable = ([
        'uuid',
        'code',
        'libelle',
        'color',
        'description',
        'etat'
    ]);
}
