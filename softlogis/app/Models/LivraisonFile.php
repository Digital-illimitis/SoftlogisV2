<?php

namespace App\Models;

use App\Models\OdLivraison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LivraisonFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'livraison_id',
        'files',
        'filePath',
        'etat',

    ];
    public function file()
    {
        return $this->belongsTo(OdLivraison::class, 'livraison_id');
    }
}
