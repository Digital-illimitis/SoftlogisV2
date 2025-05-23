<?php

namespace App\Models;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\FacturePrestation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refacturation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'etat',
        'code',
        'statut',

        'refClient',
        'doit',
        'adresseComplete',
        'num_cc',
        'pol',
        'pod',
        'regime',
        'email',

        // info produit
        'designation',
        'num_Commande',
        'num_Bl',
        'navire',
        'destination',
        'amateur',
        'num_Dossier',
        'num_Ot',
        'volume',

        // info facturier
        'facturier_uuid',
        'poste_occuper',
        'num_facture',
        'date_echeance',
        'condition_paiement',
        'comment',

        //
        'tva',
        'nbr_product',

        //log
        'date_sendToClient',
        'user_sendToClient',

        'date_payed',
        'user_payed',
    ];
    protected $dates = ['date_echeance', 'date_sendToClient', 'date_payed'];

    public function facturier()
    {
        return $this->belongsTo(User::class, 'facturier_uuid', 'uuid');
    }
    public function prestations()
    {
        return $this->hasMany(FacturePrestation::class, 'facture_uuid', 'uuid');
    }

}
