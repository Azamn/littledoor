<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorPaymentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function doctor(){
        return $this->belongsTo(MasterDoctor::class,'doctor_id','id');
    }
}
