<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->belongsTo(JobCreator::class, 'job_creator_id');
    }

    public function tags()
    {
        return $this->belongsToMany(JobTag::class, 'job_post_tags', 'job_post_id', 'job_tag_id');
    }
}
