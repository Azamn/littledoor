<?php

namespace App\Models;

use App\Models\MasterDoctor;
use App\Models\MasterTimeSlot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "patient_appointments";

    public function slot()
    {
        return $this->belongsTo(MasterTimeSlot::class, 'slot_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(MasterDoctor::class, 'doctor_id', 'id');
    }
}
