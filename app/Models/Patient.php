<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'age',
        'blood_group',
        'marital_status',
        'address',
        'contact_number',
        'patient_diagnose',
        'past_illness',
        'past_surgeries',
        'allergic',
        'primary_care_physician',
        'status',
    ];
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

}
