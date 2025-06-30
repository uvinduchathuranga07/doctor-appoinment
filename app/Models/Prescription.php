<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['doctor_schedule_id', 'patient_id', 'details'];

    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }

    public function patient()
    {
        return $this->belongsTo(Customer::class, 'patient_id');
    }
}
