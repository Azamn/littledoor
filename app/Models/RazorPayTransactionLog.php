<?php

namespace App\Models;

use App\Models\MasterPatient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RazorPayTransactionLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(MasterPatient::class, 'patient_id', 'id');
    }
}
