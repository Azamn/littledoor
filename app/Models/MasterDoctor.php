<?php

namespace App\Models;

use App\Models\MasterCity;
use Spatie\MediaLibrary\HasMedia;
use App\Models\DoctorAdressMapping;
use App\Models\DoctorEducationMapping;
use Illuminate\Database\Eloquent\Model;
use App\Models\DoctorAppreciationMapping;
use App\Models\DoctorWorkExperienceMapping;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterDoctor extends Model implements HasMedia
{
    use HasFactory,SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $table = 'master_doctors';


    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function doctorWorkMapping(){
        return $this->hasMany(DoctorWorkExperienceMapping::class,'doctor_id','id');
    }

    public function doctorEducationMapping(){
        return $this->hasMany(DoctorEducationMapping::class, 'doctor_id','id');
    }

    public function doctorSkillsMapping(){
        return $this->hasMany(DoctorSkillsMapping::class, 'doctor_id','id');
    }

    public function doctorAdressMapping(){
        return $this->hasMany(DoctorAdressMapping::class, 'doctor_id','id');
    }

    public function doctorAppreciationMapping(){
        return $this->hasMany(DoctorAppreciationMapping::class, 'doctor_id','id');
    }

    public function otherDocMapping(){
        return $this->hasMany(DoctorOtherDocumentMapping::class,'doctor_id','id');
    }

    public function city(){
        return $this->belongsTo(MasterCity::class, 'city_id','id');
    }
}
