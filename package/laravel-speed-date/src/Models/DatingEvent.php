<?php

namespace Bunker\LaravelSpeedDate\Models;

use App\Models\User;
use Bunker\LaravelSpeedDate\Enums\EventTypeEnum;
use Bunker\LaravelSpeedDate\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DatingEvent extends Model
{
    use HasFactory;

    // Specify the custom table name
    protected $table = "dating_events";

    // Define fillable attributes
    protected $fillable = ['name', 'happens_on', 'type', 'status'];

    // Define casting for attributes
    protected $casts = ['name' => 'string', 'status' => 'boolean', // Casting 'status' attribute to boolean
        'happens_on' => 'datetime' // Casting 'happens_on' attribute to datetime
    ];

    // Define relationship with participants (users)
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_users', 'event_id', 'user_id');
    }

    // Define relationship with participants (users)
    public function ratings()
    {
        return $this->hasMany(RatingEvent::class, 'event_id', 'id');
    }
    // Define relationship with participants (users)
    public function matchedParticipants($user)
    {
        return $this->participants()->where('user_id', '!=', $user->id)->whereHas('bio', function ($query) use ($user) {
            $eventType = $this->type;
            $userGender = $user->bio->gender;

            $targetGender = ($eventType == EventTypeEnum::STRAIGHT) ? 
                ($userGender == GenderEnum::MALE ? GenderEnum::FEMALE : GenderEnum::MALE) :
                ($userGender == GenderEnum::MALE ? GenderEnum::MALE : GenderEnum::FEMALE);

            $query->where('gender', $targetGender);
        }); // Ensure to retrieve the matched participants
    }

    public function eventRatings()
    {
        return $this->hasMany(RatingEvent::class, 'event_id');
    }

    function ratingStatusOfParticipant(User $user)
    {
        // Get all participants of the event
        $participants = $this->matchedParticipants($user);
        if($participants->count() > 0){
            // Get all other participants except the current one
            $otherParticipants = $participants->select('users.id')
                ->where('users.id', '!=', $user->id)
                ->get();

            // Check if the participant has rated all other participants
            $ratingsCount = $this->eventRatings()->where('user_id_from', $user->id)
                ->whereIn('user_id_to', $otherParticipants->pluck('id'))
                ->where('event_id', $this->id)
                ->count();

            // Check if the count of ratings matches the count of other participants
            if ($ratingsCount !== $otherParticipants->count() || $otherParticipants->count() <= 0 || $ratingsCount <= 0) {
                return 'Still Voting: '.$ratingsCount.' '.$otherParticipants->count().' '.$otherParticipants->pluck('id');
            }
        }
        
        return 'Done';
    }

    function checkMatchedRatedEachOther()
    {

    }

    function getRating(User $userFrom, User $userTo)    
    {
        return $this->eventRatings()->where('user_id_from', $userFrom->id)->where('user_id_to', $userTo->id)->first();
    }
    public function hasRatingsFromParticipants($userId)
    {
        return $this->eventRatings()
            ->where(function ($query) use ($userId) {
                $query->where('user_id_to', $userId)
                    ->orWhere('user_id_from', $userId);
            })
            ->exists();
    }


}

