<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Expedition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expedition_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'famille_uuid',
        'etat',
        'expedition_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Article::class, 'product_id');
    }

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_id', 'id');
    }
}
