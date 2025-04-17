<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // The table associated with the model (optional if naming follows Laravel convention)
    protected $table = 'tasks';

    // Fields that are mass assignable
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'attachment',
    ];
}
