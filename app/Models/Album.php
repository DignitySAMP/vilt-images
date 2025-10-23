<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Image;


class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'name', 'description', 'is_hidden'
    ];

    /** 
    ** Eloquent relationships
    */
    
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function images(): HasMany {
        return $this->hasMany(Image::class);
    }

    /** 
    ** Scopes
    */
    
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', 0);
    }
}
