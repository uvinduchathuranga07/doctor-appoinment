<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'details',
        'status',
        'pharmacy_name',
    ];

    protected $casts = [
        'details' => 'array', // Automatically cast JSON to array
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function patient()
    {
        return $this->belongsTo(Customer::class, 'patient_id');
    }
}
