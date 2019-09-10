<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hashId',
        'from',
        'to',
        'FileOriginalName',
        'fileExtension',
    ];
}
