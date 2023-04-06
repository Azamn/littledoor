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
}
