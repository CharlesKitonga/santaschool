<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Philosophy extends Model
{
    protected $fillable = [
        'heading', 'description', 'photo',
    ];
}
