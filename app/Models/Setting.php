<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'key',
        'value'
    ];
}
