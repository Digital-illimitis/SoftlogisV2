<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination_arret extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid_arret',
        'uuid_destination',
    ];
}
