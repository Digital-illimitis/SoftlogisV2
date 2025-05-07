<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Od_files extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'od_transite_id',
        'name',
        'files',
        'filePath',
        'etat',
    ];
    public function file()
    {
        return $this->belongsTo(OdTransite::class, 'od_transite_id');
    }
}
