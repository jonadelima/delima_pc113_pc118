<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'subject',
        'type',
        'assigned_to',
        'due_date',
        'file',
    ];
}
