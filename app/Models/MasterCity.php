<?php

namespace App\Models;

use App\Models\MasterState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterCity extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'master_cities';

    public function state(){
        return $this->belongsTo(MasterState::class,'state_id','id');
    }
}
