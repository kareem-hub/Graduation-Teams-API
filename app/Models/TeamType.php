<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamType extends Model
{
    use HasFactory;

    const GENERAL = 1;
    const PRIVATE = 2;

    protected $fillable = [
        'name'
    ];
}
