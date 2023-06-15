<?php

namespace App\Models;

use App\Models\MasterOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategoryQuestionMappingWithOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'sub_category_question_mapping_with_options';

    public function option(){
        return $this->belongsTo(MasterOption::class, 'option_id','id');
    }
}
