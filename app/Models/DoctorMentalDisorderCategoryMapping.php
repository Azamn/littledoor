<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorMentalDisorderCategoryMapping extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'doctor_mental_disorder_category_mappings';

}
