<?php

namespace App\Models;

use Bunker\LaravelSpeedDate\Models\DatingEvent;
use Bunker\LaravelSpeedDate\Models\EventRating;
use Bunker\LaravelSpeedDate\Models\RatingEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Bunker\LaravelSpeedDate\Models\UserBio;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attribute for table related to this model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['uuid', 'name', 'email', 'avatar', 'status', 'password',];

    /**
     * The attributes that will be set by SoftDeletes action
     *
     * @var array<string>
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed',];

    public function bio(): HasOne
    {
        return $this->hasOne(UserBio::class);
    }

    public function events()
    {
        return $this->belongsToMany(DatingEvent::class, 'event_users', 'user_id', 'event_id');
    }

    public function getEvent($eventId)
    {
        return $this->events->where('id',$eventId)->first();
    }

    public function eventRatingsGiven()
    {
        return $this->hasMany(RatingEvent::class, 'user_id_from');
    }

    public function getValidRatingsForEvent($eventId)
    {
        $matchedParticipants = $this->getEvent($eventId)->matchedParticipants($this)->get();
    
        foreach ($matchedParticipants as $key => $matchedParticipant) {
            $ratingEvent = $this->getEvent($eventId)->first();
    
            $ratingNoFrom = $ratingEvent->ratings()
                ->where('user_id_from', $this->id)
                ->where('user_id_to', $matchedParticipant->id)
                ->where('rating', 'no')
                ->exists();
    
            $ratingNoTo = $ratingEvent->ratings()
                ->where('user_id_to', $this->id)
                ->where('user_id_from', $matchedParticipant->id)
                ->where('rating', 'no')
                ->exists();
    
            if ($ratingNoFrom || $ratingNoTo) {
                unset($matchedParticipants[$key]);
            }
        }
    
        return $matchedParticipants;
    }
    
    public function canSee($otheruserid){
        $otherusersid = $this->events()->latest('created_at')->first()->matchedParticipants($this)->get()->pluck('id')->toArray();
        return in_array($otheruserid,$otherusersid);
    }
}
