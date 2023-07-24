<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTag extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_tags', 'job_tag_id', 'job_post_id');
    }
}
