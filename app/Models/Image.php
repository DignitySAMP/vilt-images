<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $fillable = [
        'publisher_id',
        'description',
        'file_name'
    ];

    public function publisher(): BelongsTo {
        return $this->belongsTo(User::class);
    }

   
    /**
     * Builds a collection of random images with similar values (file_name, description, publisher.name)
     *
     * @return Collection
     */

    public function similar(): Collection
    {
        return self::with('publisher')
            ->where( 'id', '!=', $this->id)
            ->where(
                column: function ($query): void {
                    $query->where( 'file_name', $this->file_name)
                    ->orWhere( 'description', $this->description )
                    ->orWhereHas( 'publisher',  function ($q): void {
                        $q->where( 'name',  $this->publisher?->name);
                    }
                );
            })
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

}
