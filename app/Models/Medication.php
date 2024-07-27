<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medication extends Model
{
    use HasApiTokens,  Notifiable, HasRoles;
    protected $fillable = [
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
