<?php

namespace App\Models;

use App\Models\Facturation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrestationLine extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'facture_uuid', 'etat', 'rubrique', 'prixUnitaire', 'qty', 'totalLigne'];

    public function facture()
    {
        return $this->belongsTo(Facturation::class, 'facture_uuid', 'uuid');
    }

    
}
