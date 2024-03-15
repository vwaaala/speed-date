<?php

namespace Bunker\LaravelSpeedDate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class RatingEvent extends Model
{
    protected $table = 'event_ratings';

    protected $fillable = ['user_id_from', 'user_id_to', 'event_id', 'rating'];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_id_from');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_id_to');
    }

    public function event()
    {
        return $this->belongsTo(DatingEvent::class, 'event_id');
    }
}
