<?php

namespace App\Models;

use App\Models\User;
use App\Models\DocAssigned;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'code',
        'etat',
        'content',
        'foreignUuid',
        'userUuid',
    ];

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userUuid', 'uuid');
    }
    public function folder(): BelongsTo
    {
        return $this->belongsTo(DocAssigned::class, 'foreignUuid', 'uuid');
    }
}