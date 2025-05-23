<?php

namespace App\Models;

use App\Models\Regime;
use App\Models\Company;
use App\Models\ExpTransport;
use App\Models\Expedition_File;
use App\Models\Expedition_product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expedition extends Model
{
    use HasFactory;



    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'date_liv',
        'num_exp',
        'incoterm',
        'lieu_liv',
        'statut',
        'regime_uuid',
        'client_uuid',
        'num_order',
        'created_by',
        'date_started',
        'date_validate_doc',
        'date_transport',
        'date_transit',
        'date_destockage',
        'dateExpedition',
        'dateLivraisonFinal',
        'dateFacturation',

        'declarationFile',
        'declarationDate',
        'declarationNum',

        'orderDate',
        'orderContent',
    ];

    protected $dates = ['date_liv', 'date_started', 'date_validate_doc','date_transit','date_destockage','date_transport'];

    public function client()
    {
        return $this->belongsTo(Company::class, 'client_uuid', 'uuid');
    }

    public function products()
    {
        return $this->hasMany(Expedition_product::class, 'expedition_id');
    }
    public function files()
    {
        return $this->hasMany(Expedition_File::class, 'expedition_id');
    }

    public function transport()
    {
        return $this->belongsTo(ExpTransport::class, 'uuid', 'expedition_uuid');
    }

    public function regime()
    {
        return $this->belongsTo(Regime::class, 'regime_uuid', 'uuid');
    }



}
