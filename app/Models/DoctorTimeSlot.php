<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorTimeSlot extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'doctor_time_slots';

    public function timeSlot(){
        return $this->belongsTo(MasterTimeSlot::class,'time_slot_id','id');
    }
}
