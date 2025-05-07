<?php

namespace App\Models;

use App\Models\User;
use App\Models\Regime;
use App\Models\DocAssigned;
use App\Models\OdLivraison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sourcing extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'statut',
        'packaging',
        'id_navire',
        'info_navire',
        'num_bl',
        'numDossier',
        'regime_uuid',
        'date_arriver', //date estimative
        'date_reel_arriver', //date reelle
        'date_depart',
        'note',
        'tostarted_by',
        'created_by',
        'tostarted_date',

        'startValidate_by',
        'startValidate_date',

        'date_receivFactCom',
        'is_receivFactCom',

        'declarationFile',
        'declarationDate',
        'declarationNum'
    ];

    protected $dates = ['date_depart', 'date_arriver', 'tostarted_date', 'startValidate_date', 'date_receivFactCom'];
    public function files()
    {
        return $this->hasMany(Sourcing_file::class);
    }
    public function folderAssign()
    {
        return $this->belongsTo(DocAssigned::class, 'uuid', 'folderUuid');
    }

    public function started_by()
    {
        return $this->belongsTo(User::class, 'tostarted_by', 'uuid');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }
    public function startValidate_by()
    {
        return $this->belongsTo(User::class, 'startValidate_by', 'uuid');
    }
    public function regime()
    {
        return $this->belongsTo(Regime::class, 'regime_uuid', 'uuid');
    }

    public function products()
    {
        return $this->hasMany(Sourcing_product::class, 'sourcing_id');
    }


    public function odLivraisons()
    {
        return $this->hasMany(OdLivraison::class, 'sourcing_id');
    }

}

