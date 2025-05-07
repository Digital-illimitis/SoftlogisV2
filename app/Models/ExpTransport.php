<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Expedition;
use App\Models\ExTransportFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpTransport extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'voie_exp',
        'transporteur_uuid',
        'expedition_uuid',
        'note',
        'destination',
        'date_transport',
        'user_uuid'
    ];

    protected $dates = ['date_transport'];

    public function transporteur()
    {
        return $this->belongsTo(Company::class, 'transporteur_uuid', 'uuid');
    }

    public function expedition()
    {
        return $this->belongsTo(Expedition::class, 'expedition_uuid', 'uuid');
    }

    public function files()
    {
        return $this->hasMany(ExTransportFile::class, 'transport_uuid');
    }

}
