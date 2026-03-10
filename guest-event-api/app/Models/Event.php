<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
