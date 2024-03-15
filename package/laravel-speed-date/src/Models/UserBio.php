<?php

namespace Bunker\LaravelSpeedDate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
class UserBio extends Model
{
    use HasFactory;

    protected $table = 'user_bio';

    protected $fillable = [
        'user_id',
        'nickname',
        'city',
        'occupation',
        'phone',
        'birthdate',
        'gender',
        'looking_for',
    ];

    protected $dates = ['birthdate'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DatingEvent::class, 'event_users');
    }
}
