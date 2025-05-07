<?php

namespace App\Models;

use App\Models\OdTransite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sourcing_file extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'uuid',
        'name',
        'sourcing_id',
        'files',
        'filePath',
        'etat',
        'statut',
        'uuid_validator',
        'date_validation',
        'doc_requis_uuid',
    ];
    public function file()
    {
        return $this->belongsTo(Sourcing::class, 'sourcing_id');
    }

    public function document(): BelongsTo
   {
       return $this->belongsTo(Document::class, 'uuid_document', 'uuid');
   }
    public function validator(): BelongsTo
   {
       return $this->belongsTo(User::class, 'uuid_validator', 'uuid');
   }


}
