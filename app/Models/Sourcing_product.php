<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sourcing_product extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'famille_uuid',
        'etat',
        'is_received',
        'sourcing_id',
        'product_id',
        'product_uuid',
    ];

    public function product()
    {
        return $this->belongsTo(Article::class, 'product_id');
    }
}
