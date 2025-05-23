<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use App\Models\Sourcing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OdTransite extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'note',
        'transitaire_uuid',
        'sourcing_uuid',
        'receive_doc',
        'receive_date',
        'user_uuid',
        'typeOp',
        
        'numConnaiOriginal',
        'navireName',
        'numConnaissement',
        'portDembarquement',
        'factFounisseur',
        'factFret',
        'colisage',
        'assurCertifNum',
        'frie',
        'sgsn',
        'numLicense',
        'exoneration',
        'marche',
        'marchandiseAction',
        'expediteTo',
        'droitCredit',
        'exoneration',
        'factAlibelle',
        'divers',
        'garantieBancaire',
        'adresseLivraison',
    ];

    protected $dates = ['receive_date'];

    public function transitaire(): BelongsTo
   {
       return $this->belongsTo(Company::class, 'transitaire_uuid', 'uuid');
   }
    public function sourcing(): BelongsTo
   {
       return $this->belongsTo(Sourcing::class, 'sourcing_uuid', 'uuid');
   }
    public function user(): BelongsTo
   {
       return $this->belongsTo(User::class, 'user_uuid', 'uuid');
   }
   public function files()
   {
       return $this->hasMany(Od_files::class);
   }

   public function products()
   {
       return $this->belongsToMany(Article::class, 'ot_products', 'ot_uuid', 'product_uuid','uuid','uuid');
   }
}
