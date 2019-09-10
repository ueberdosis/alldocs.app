<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'from',
        'to',
        'filename',
        'new_filename',
    ];
}
