<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamLeader extends Model
{
    protected $fillable = [
        'name','title','description','photo',
    ];
}
