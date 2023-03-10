<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'master_cities';

    public function state(){
        return $this->belongsTo(MasterState::class,'state_id','id');
    }
}
