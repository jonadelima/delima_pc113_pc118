<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\Configuration\Php;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'position'];
}
