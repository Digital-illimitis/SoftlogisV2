<?php

namespace App\Models;

use App\Models\FacturePrestation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactureDoc extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'etat', 'facture_uuid', 'file_path', 'facture_original'];

    public function facture()
    {
        return $this->belongsTo(FacturePrestation::class, 'facture_uuid', 'uuid');
    }
}
