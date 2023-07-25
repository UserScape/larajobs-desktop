<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'published_at' => 'immutable_datetime',
        'applied_at' => 'immutable_datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getIsAppliedAttribute()
    {
        return ! empty($this->applied_at);
    }

    public function getNotificationMessageAttribute()
    {
        $message = "By: {$this->company->name}," . PHP_EOL;

        if ($this->location) {
            $message .= "Location: {$this->location}," . PHP_EOL;
        }

        if ($this->salary) {
            $message .= "Salary: {$this->salary}," . PHP_EOL;
        }

        $message .= "Published: {$this->published_at->diffForHumans(short: true)}";

        return $message;
    }
}
