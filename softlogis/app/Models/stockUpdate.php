<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use App\Models\Entrepot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class stockUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'product_id',
        'mouvement',
        'file',
        'conformity',
        'note',
        'conformityOut',
        'noteOut',
        'in_date',
        'out_date',
        'entrepot_uuid',
        'user_id',
    ];


    public function product()
    {
        return $this->belongsTo(Article::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_uuid', 'uuid');
    }
}
