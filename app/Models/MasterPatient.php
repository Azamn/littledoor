<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MasterPatient extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'master_patients';

    public function city(){
        return $this->belongsTo(MasterCity::class, 'city_id','id');
    }
}
