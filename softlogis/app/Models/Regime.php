<?php

namespace App\Models;

use App\Models\Sourcing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regime extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'regime',
        'description',
        'etat'
    ];


    public function sourcings()
    {
        return $this->hasMany(Sourcing::class, 'regime_uuid', 'uuid');
    }
}
