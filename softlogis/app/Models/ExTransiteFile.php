<?php

namespace App\Models;

use App\Models\ExTransit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExTransiteFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'transite_uuid',
        'files',
        'user_uuid',
        'filePath',
        'etat',
        'statut',
    ];
    public function file()
    {
        return $this->belongsTo(ExTransit::class, 'transite_uuid', 'uuid');
    }

    public function transite()
    {
        return $this->belongsTo(ExTransit::class, 'transite_uuid', 'uuid');
    }
}
