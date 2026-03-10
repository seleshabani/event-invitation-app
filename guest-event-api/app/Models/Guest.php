<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    //

    protected $fillable = [
        'name',
        'email',
        'event_id',
        'is_invitation_send'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
