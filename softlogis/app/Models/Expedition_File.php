<?php

namespace App\Models;

use App\Models\Expedition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expedition_File extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'expedition_id',
        'files',
        'filePath',
        'etat',
        'statut',
    ];
    public function file()
    {
        return $this->belongsTo(Expedition::class, 'expedition_id');
    }
}
