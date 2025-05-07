<?php

namespace App\Models;

use App\Models\ExpTransport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExTransportFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'transport_uuid',
        'files',
        'user_uuid',
        'filePath',
        'etat',
        'statut',
    ];

    public function file()
    {
        return $this->belongsTo(ExpTransport::class, 'transport_uuid');
    }
}
