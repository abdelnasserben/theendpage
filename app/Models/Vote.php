<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'departure_page_id',
        'voter_ip',
        'user_id'
    ];

    public function page()
    {
        return $this->belongsTo(DeparturePage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
