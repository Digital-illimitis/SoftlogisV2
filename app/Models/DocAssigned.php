<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sourcing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocAssigned extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'folderUuid',//sourcing
        'userUuid',
        'backupUuid',
        'assignedByUuid',
        'datasfile',
        'status',
    ];

    /**
     * Get the user folder that owns the DocAssigned
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userUuid', 'uuid');
    }
    public function backup(): BelongsTo
    {
        return $this->belongsTo(User::class, 'backupUuid', 'uuid');
    }
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Sourcing::class, 'folderUuid', 'uuid');
    }
}
