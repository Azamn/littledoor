<?php

namespace App\Models;

use App\Models\MasterEmotions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyJournal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = "daily_journals";

    public function emotion(){
        return $this->belongsTo(MasterEmotions::class,'emotion_id','id');
    }
}
