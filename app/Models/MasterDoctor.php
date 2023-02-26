<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterDoctor extends Model implements HasMedia
{
    use HasFactory,SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $table = 'master_doctors';
}
