<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Larajob extends Model
{

    protected $fillable = ['title', 'link', 'company', 'location',
        'salary', 'icon', 'seen', 'pub_date', 'tags', 'job_type' ];

    protected $dates = [ 'pub_date' ];

    protected $casts = [
        'pub_date' => 'datetime',
        'seen' => 'boolean'
    ];

    function getTypeAttribute()
    {
        switch($this->job_type) {
            case 'FULL_TIME':
                return 'Full time';
            case 'PART_TIME':
                return 'Part time';
            default:
                return $this->job_type;
        }
    }

    function getHasIconAttribute()
    {
        return $this->icon !== 'https://larajobs.com/logos/';
    }

}
