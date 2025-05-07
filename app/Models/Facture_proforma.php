<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture_proforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'transporteur_uuid',
        'destination_uuid',
        'porteChar_uuid',
        'montant',
        'etat',
        'code',
    ];

    public function transporteur()
    {
        return $this->belongsTo(Company::class, 'transporteur_uuid', 'uuid');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_uuid', 'uuid');
    }

    public function porteChar()
    {
        return $this->belongsTo(PorteChar::class, 'porteChar_uuid', 'uuid');
    }
}
   