<?php

namespace App\Models;

use App\Models\Company;
use App\Models\PorteChar;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactProforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'transporteur_uuid',
        'destination_uuid',
        'porteChar_uuid',
        'cout_prestation',
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
