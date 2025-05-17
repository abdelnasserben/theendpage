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
        'anonymous', 
        'release_at'
    ];
}
