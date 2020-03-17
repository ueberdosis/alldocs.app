<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'archived_at',
    ];

    public function getStoragePathAttribute()
    {
        return storage_path("app/public/{$this->hashId}");
    }

    public function getNewFileNameAttribute()
    {
        // TODO: Should pick file extension from config
        return "{$this->FileOriginalName}.{$this->to}";
    }

    public function scopeUnarchived($query)
    {
        return $query->whereNull('archived_at');
    }

    public function archive()
    {
        Storage::delete([
            "public/{$this->id}",
            "public/{$this->hashId}",
        ]);

        $this->update([
            'archived_at' => now(),
            'FileOriginalName' => null,
        ]);
    }
}
