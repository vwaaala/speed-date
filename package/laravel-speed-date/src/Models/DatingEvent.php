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
    public function matchedParticipants()
    {
        $authUser = auth()->user();
        if($authUser->id == 1){
            return $this->belongsToMany(User::class, 'event_users', 'event_id', 'user_id');
        }
        return $this->participants()->whereHas('bio', function ($query) use ($authUser) {
            if($authUser->events->first()->type == EventTypeEnum::STRAIGHT){
                if($authUser->bio->gender == GenderEnum::MALE){
                    $query->where('gender', GenderEnum::FEMALE);
                } else {
                    $query->where('gender', GenderEnum::MALE);
                } 
            } else {
                if($authUser->bio->gender == GenderEnum::MALE){
                    $query->where('gender', GenderEnum::MALE);
                } else {
                    $query->where('gender', GenderEnum::FEMALE);
                }
            }
            
        });
    }

    public function eventRatings()
    {
        return $this->hasMany(RatingEvent::class, 'event_id');
    }

    function getEventRatingForUser($eventId)
    {
        // Get all participants of the event
        $participants = $this->matchedParticipants;
        if(count($participants) > 0){
            foreach ($participants as $participant) {
                // Get all other participants except the current one
                $otherParticipants = $participants->except($participant->id);
    
                // Check if the participant has rated all other participants
                $ratingsCount = RatingEvent::where('user_id_from', $participant->id)
                    ->whereIn('user_id_to', $otherParticipants->pluck('id'))
                    ->where('event_id', $eventId)
                    ->count();
    
                // Check if the count of ratings matches the count of other participants
                if ($ratingsCount !== $otherParticipants->count()) {
                    return 'Still Voting';
                }
            }
        }
        

        return 'Done';
    }

}

