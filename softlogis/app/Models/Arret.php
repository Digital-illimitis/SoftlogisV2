<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arret extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'libelle',
        'description',
        'etat'
    ];

    public function destinations()
    {
        return $this->belongsToMany(TransportDestination::class, 'destination_arrets', 'arret_id', 'transport_destination_id');
    }
}
