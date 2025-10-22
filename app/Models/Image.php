<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $fillable = [
        'album_id',
        'publisher_id',
        'name',
        'description',
        'file_name',
        'path',
        'is_hidden'
    ];
    
    protected $appends = [
        'url', 
        'thumbnail_url',
        'file_size'
    ];

    /** 
    ** Eloquent relationships
    */

    public function publisher(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function album(): BelongsTo {
        return $this->belongsTo(Album::class);
    }
   
    /** 
    ** Custom collections
    */

    // Builds a collection of random images with similar values (file_name, description, publisher.name)
    public function similar(): Collection
    {
        return self::with(['publisher', 'album'])
            ->where( 'id', '!=', $this->id)
            ->where(
                column: function ($query): void {
                    $query->where( 'file_name', $this->file_name)
                    ->orWhere( 'description', $this->description )
                    ->orWhere( 'album_id', $this->album_id)
                    ->orWhereHas( 'publisher',  function ($q): void {
                        $q->where( 'name',  $this->publisher?->name);
                    }
                );
            })
            ->visible()
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }
    /** 
    ** Scopes
    */
    
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', 0)
            ->where(function ($q) {
                $q->whereHas('album', function ($query) {
                    $query->where('is_hidden', 0);
                })
                ->orWhereNull('album_id');
            });
    }

    /** 
    ** Accessors
    */
    
    public function getUrlAttribute(): string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        return $disk->url("{$this->path}/{$this->file_name}");
    }

    public function getThumbnailUrlAttribute(): string
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
        return $disk->url("{$this->path}/thumbnails/{$this->file_name}");
    }

    public function getFileSizeAttribute(): int
    {
        $disk = Storage::disk('public');
        $filePath = "{$this->path}/{$this->file_name}";

        if ($disk->exists($filePath)) {
            return $disk->size($filePath);
        }

        return 0; // no size
    }
}
