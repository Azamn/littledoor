<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MentalDisorderCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'mental_disorder_categories';

    public function mentalDisorderQuestion(){
        return $this->hasMany(MentalDisorderCategoryQuestionMapping::class,'mental_disorder_category_id','id');
    }

}
