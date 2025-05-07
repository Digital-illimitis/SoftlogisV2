<?php

namespace App\Models;

use App\Models\Refacturation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturePrestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'facture_uuid',
        'type_prestation',
        'qty',
        'description',
        'prixunitaire',
        'total',
    ];

    public function facture()
    {
        return $this->belongsTo(Refacturation::class, 'facture_uuid');
    }
}
