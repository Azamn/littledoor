<?php

namespace App\Models;

use App\Models\MasterDoctor;
use App\Models\MasterPatient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(MasterPatient::class, 'sender_id', 'id' );
    }

    public function doctor()
    {
        return $this->belongsTo(MasterDoctor::class,  'receiver_id', 'id');
    }

}
