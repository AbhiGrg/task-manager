<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskTimeline;
use App\Models\User;

class Task extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'assigned_to',
    ];

    public function timelines()
    {
        return $this->hasMany(TaskTimeline::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'createdb_by');
    }
}
