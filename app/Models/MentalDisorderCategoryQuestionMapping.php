<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MentalDisorderCategoryQuestionMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'mental_disorder_category_question_mappings';

    public function mentalDisorderCategory(){
        return $this->belongsTo(MentalDisorderCategory::class,'mental_disorder_category_id','id');
    }
}
