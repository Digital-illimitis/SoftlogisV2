<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dollars extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'value',
        'etat',
        'type'
    ];
}
