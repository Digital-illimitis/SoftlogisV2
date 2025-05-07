<?php

namespace App\Models;


use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Entrepot extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'nom',
        'emplacement',
        'capacity',
        'color',
        'etat',
        'description',
    ];

    public function produits()
    {
        return $this->hasMany(Article::class);
    }

}
