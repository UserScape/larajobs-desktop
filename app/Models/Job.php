<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    protected $connection = 'sqlite';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'link',
        'creator',
        'category',
        'location',
        'job_type',
        'salary',
        'company',
        'company_logo',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags(): HasMany
    {
        return $this->hasMany(JobTag::class);
    }

    public function scopeFiltered(Builder $builder)
    {
        // Do we have any filters?
        if ($filters = Filter::get()) {
            // If so, filter the query.
            $builder->where(function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    list($field, $operator, $value) = $filter->operationToQuery();

                    $query->orWhere($field, $operator, $value);
                }
            });
        }

        return $builder->orderBy('posted_at', 'desc');
    }
}
