<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use App\Models\Expedition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
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
        'client_uuid',
        'created_by',
        'date_started',
    ];

    // protected $dates = ['date_liv', 'date_started',];



    public function client()
    {
        return $this->belongsTo(Company::class, 'client_uuid', 'uuid');
    }


    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }


   
    public function products()
    {
        return $this->hasMany(Expedition_product::class, 'expedition_id');
    }
    public function files()
    {
        return $this->hasMany(Expedition_File::class, 'expedition_id');
    }
}
