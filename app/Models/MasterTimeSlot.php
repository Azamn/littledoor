<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTimeSlot extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "master_time_slots";

}
