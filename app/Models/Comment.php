<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'departure_page_id',
        'author',
        'content',
        'user_id',
    ];

    public function page()
    {
        return $this->belongsTo(DeparturePage::class);
    }
}
