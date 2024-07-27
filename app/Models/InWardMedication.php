<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InWardMedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'name',
        'dose',
        'route',
        'frequency',
        'indication',
        'discrepancy',
        'resolution_plane',
        'status',
    ];
}
