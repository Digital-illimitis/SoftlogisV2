<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use App\Models\FactureDoc;
use App\Models\PrestationLine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facturation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'statut',
        'numFacture',
        'date_echeance',
        'typeFacture',
        'transitaire_uuid',
        'transporteur_uuid',
        'num_bl',
        'file_Bl',

        'facture_original',
        'note',
        'user_create',

        'user_payed',
        'date_paiement',
    ];


    protected $dates = ['date_paiement', 'date_echeance'];

    public function transporteur()
    {
        return $this->belongsTo(Company::class, 'transporteur_uuid', 'uuid');
    }
    public function transitaire()
    {
        return $this->belongsTo(Company::class, 'transitaire_uuid', 'uuid');
    }

    public function create_By()
    {
        return $this->belongsTo(User::class, 'user_create');
    }


    public function payed_by()
    {
        return $this->belongsTo(User::class, 'user_payed');
    }
    public function prestationLines()
    {
        return $this->hasMany(PrestationLine::class, 'facture_uuid', 'uuid');
    }

    public function factureDoc()
    {
        return $this->hasMany(FactureDoc::class, 'facture_uuid', 'uuid');
    }

}
