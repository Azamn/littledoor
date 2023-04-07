<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoryQuestionOptionMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'sub_category_question_option_mappings';

    public function subCategory(){
        return $this->belongsTo(MasterSubCategory::class,'master_sub_category_id','id');
    }

    public function question(){
        return $this->belongsTo(MasterQuestion::class,'master_question_id','id');
    }

    public function options(){
        return $this->belongsTo(MasterOption::class, 'master_option_id','id');
    }
}
