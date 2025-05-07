<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty',
        'ot_uuid',
        'product_uuid',
    ];

    public function product()
    {
        return $this->belongsTo(Article::class, 'product_uuid', 'uuid');
    }


}
