<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash_id',
        'from',
        'to',
        'file_original_name',
        'file_extension',
        'archived_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->hash_id = (new Hashids('conversion', 5))->encode(now()->timestamp);
        });
    }

    public function getOriginalFileAttribute()
    {
        return storage_path("app/public/{$this->id}");
    }

    public function getConvertedFileAttribute()
    {
        return storage_path("app/public/{$this->hash_id}");
    }

    public function getConvertedFileNameAttribute()
    {
        // TODO: Should pick file extension from config
        return "{$this->file_original_name}.{$this->to}";
    }

    public function scopeUnarchived($query)
    {
        return $query->whereNull('archived_at');
    }

    public function archive()
    {
        Storage::delete([
            "public/{$this->id}",
            "public/{$this->hash_id}",
        ]);

        $this->update([
            'archived_at' => now(),
            'file_original_name' => null,
        ]);
    }
}
