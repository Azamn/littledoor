<?php

namespace App\Models;

use App\Models\MasterCity;
use App\Models\MasterState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorAdressMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'doctor_adress_mappings';

    public function city(){
        return $this->belongsTo(MasterCity::class, 'city_id','id');
    }

    public function state(){
        return $this->belongsTo(MasterState::class,'state_id','id');
    }

}
