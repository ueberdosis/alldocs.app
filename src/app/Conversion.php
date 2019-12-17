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
    public function getStoragePathAttribute()
    {
        return storage_path("app/public/{$this->hashId}");
    }

    public function getNewFileNameAttribute()
    {
        return "{$this->FileOriginalName}.{$this->to}";
    }
}
