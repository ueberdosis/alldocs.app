<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'hashId',
        'from',
        'to',
        'FileOriginalName',
        'fileExtension',
    ];
}
