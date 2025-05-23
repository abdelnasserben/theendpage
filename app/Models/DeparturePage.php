<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeparturePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'tone',
        'message',
        'gif',
        'sound',
        'author_name',
        'author_email',
        'anonymous',
        'release_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
