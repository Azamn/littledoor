<?php

namespace App\Models;

use App\Models\MasterSkill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSkillsMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'doctor_skills_mappings';

    public function skill(){
        return $this->belongsTo(MasterSkill::class,'skill_id','id');
    }
}
