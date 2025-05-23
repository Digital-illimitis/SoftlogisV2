<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Sourcing;
use App\Models\OtProduct;
use App\Models\LivraisonFile;
use App\Models\TransportDestination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OdLivraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'note',
        'transporteur_uuid',
        'date_livraison',
        'lieu_livraison',
        'created_by',
        'sourcing_id',

        'numOt',
        'numFolder',
        'numBl',
        'trajetStart_uuid',
        'trajetEnd_uuid',
        'refCotation',
        'nbrMachine',
        'productUuid',
        
    ];

    public function files()
    {
        return $this->hasMany(LivraisonFile::class, 'livraison_id');
    }

    public function transporteur(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'transporteur_uuid', 'uuid');
    }


    public function sourcing()
    {
        return $this->belongsTo(Sourcing::class, 'sourcing_id', 'uuid');
    }

    public function products()
    {
        return $this->belongsToMany(Article::class, 'ot_products', 'ot_uuid', 'product_uuid')
                    ->withPivot('qty'); // Inclure la quantité dans la relation
    }

    public function otProducts()
    {
        return $this->hasMany(OtProduct::class, 'ot_uuid', 'uuid');
    }

    public function trajetStart()
    {
        return $this->belongsTo(TransportDestination::class, 'trajetStart_uuid', 'uuid');
    }
    public function trajetEnd()
    {
        return $this->belongsTo(TransportDestination::class, 'trajetEnd_uuid', 'uuid');
    }

    

}
