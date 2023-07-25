<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'job_creator_id',
        'title',
        'link',
        'creator',
        'category',
        'location',
        'type',
        'salary',
        'company',
        'company_logo',
        'published_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'hidden_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(JobCreator::class, 'job_creator_id');
    }

    public function tags()
    {
        return $this->belongsToMany(JobTag::class, 'job_post_tags', 'job_post_id', 'job_tag_id');
    }

    public function scopeUnnotified(Builder $builder)
    {
        return $builder->whereNull('notified_at');
    }

    public function scopeVisible(Builder $builder)
    {
        return $builder->whereNull('hidden_at');
    }

    public function scopeFiltered(Builder $builder)
    {
        // Do we have any filters?
        if ($filters = FilterRule::get()) {
            // If so, filter the query.
            $builder->where(function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    list($field, $operator, $value) = $filter->operationToQuery();

                    $query->orWhere($field, $operator, $value);
                }
            });
        }

        return $builder->visible()->orderBy('published_at', 'desc');
    }
}
