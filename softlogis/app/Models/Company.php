<?php

namespace App\Models;

use App\Models\GrilleTarif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'logo',
        'code',
        'type', //organisation transit transport Clients  et etc
        'voie_transport',
        'identification', //registre de commerce
        'raison_sociale',
        'email',
        'phone',
        'localisation',
        'description',
        'etat',
        'contact_one_name',
        'contact_one_lastName',
        'contact_one_email',
        'contact_two_name',
        'contact_two_lastName',
        'contact_two_email',
        'isActive',
        'add_access',
    ];

    public function grilleTarifaire()
    {
        return $this->hasMany(GrilleTarif::class);
    }
}
