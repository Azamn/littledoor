<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientQuestionOptionMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "patient_question_option_mappings";

    public function subCategoryQuestionMapping(){
        return $this->belongsTo(SubCategoryQuestionMapping::class, 'category_question_mapping_id','id');
    }
}
