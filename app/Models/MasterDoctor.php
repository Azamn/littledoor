<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use App\Models\DoctorEducationMapping;
use Illuminate\Database\Eloquent\Model;
use App\Models\DoctorWorkExperienceMapping;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterDoctor extends Model implements HasMedia
{
    use HasFactory,SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $table = 'master_doctors';

    public function doctorWorkMapping(){
        return $this->hasMany(DoctorWorkExperienceMapping::class,'doctor_id','id');
    }

    public function doctorEducationMapping(){
        return $this->hasMany(DoctorEducationMapping::class, 'doctor_id','id');
    }

    public function doctorSkillsMapping(){
        return $this->hasMany(DoctorSkillsMapping::class, 'doctor_id','id');
    }
}
