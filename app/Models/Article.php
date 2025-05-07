<?php

namespace App\Models;

use App\Models\Entrepot;
use App\Models\OtProduct;
use App\Models\stockUpdate;
use App\Models\ArticleModel;
use App\Models\FamillyGroup;
use App\Models\ArticleFamily;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

   protected $fillable = [
    'uuid',
    'code',
    'numero_bon_commande',
    'numero_serie',
    'description',
    'image',
    'marque_uuid',
    'categorie_uuid',
    'famille_uuid',
    'model_uuid',
    'model_Materiel',
    'num_billOfLading',
    'source_uuid',
    'packaging',
    'type_container',
    'entrepot_uuid',
    'status',
    'familyGroup',
    'poid_tonne',
    'hauteur',
    'largeur',
    'volume',
    'longueur',
    'price_unitaire',
    'price_dollars',
    'price_euro',
    'etat',
    'is_AddSourcing',
    'is_destock',

    'date_reception',
    'date_stockage',
    'date_Eta',
    'date_outStock',
    
   ];

   /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

     protected $dates = ['date_reception', 'date_stockage', 'date_Eta', 'date_outStock'];

   public function category(): BelongsTo
   {
       return $this->belongsTo(Category::class, 'categorie_uuid', 'uuid');
   }
   public function model(): BelongsTo
   {
       return $this->belongsTo(ArticleModel::class, 'model_uuid', 'uuid');
   }
   public function familly(): BelongsTo
   {
       return $this->belongsTo(ArticleFamily::class, 'famille_uuid', 'uuid');
   }
   public function marque(): BelongsTo
   {
       return $this->belongsTo(Marque::class, 'marque_uuid', 'uuid');
   }
   public function ship_source(): BelongsTo
   {
       return $this->belongsTo(Source::class, 'source_uuid', 'uuid');
   }

   public function stockUpdates()
   {
       return $this->hasMany(stockUpdate::class, 'product_id');
   }

   public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'entrepot_uuid', 'uuid');
    }

    public function otProduct()
    {
        return $this->belongsToMany(OtProduct::class, 'product_uuid', 'uuid');
    }

    public function famillyGroup()
    {
        return $this->belongsTo(FamillyGroup::class, 'familyGroup', 'uuid');
    }

}
