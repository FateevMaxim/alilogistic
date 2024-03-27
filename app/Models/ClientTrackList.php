<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTrackList extends Model
{
    protected $fillable = [
        'detail',
        'track_code'
    ];
}
