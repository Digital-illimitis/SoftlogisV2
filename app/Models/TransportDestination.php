<?php

namespace App\Models;

use App\Models\Arret;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'libelle',
        'arret_uuid',
        'description',
        'etat'
    ];


    public function arrets()
    {
        return $this->belongsToMany(Arret::class, 'destination_arrets', 'transport_destination_id', 'arret_id');
    }

}
