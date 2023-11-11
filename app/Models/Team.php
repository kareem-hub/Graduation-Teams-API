<?php

namespace App\Models;

use App\Builders\TeamBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_type_id',
        'title',
        'body',
        'published',
        'rating'
    ];

    public function newEloquentBuilder($query): TeamBuilder
    {
        return new TeamBuilder($query);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
