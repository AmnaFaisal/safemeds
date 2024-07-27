<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'status',
        'comment',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function pastMedications()
    {
        return $this->hasMany(PastMedication::class);
    }

    public function inWardMedications()
    {
        return $this->hasMany(InWardMedication::class);
    }
}
