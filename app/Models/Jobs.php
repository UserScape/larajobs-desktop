<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobs extends Model
{
    use HasFactory, HasUlids, SoftDeletes, HasTimestamps, Prunable;

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth())->orWhereNotNull('deleted_at');
    }

    /**
     * @var array
     */
    protected $fillable = ['title', 'url', 'published_at', 'creator', 'guid'];
}
