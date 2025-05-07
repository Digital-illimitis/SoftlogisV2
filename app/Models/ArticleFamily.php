<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleFamily extends Model
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



    public function articles()
    {
        return $this->hasMany(Article::class, 'famille_uuid', 'uuid');
    }
}
