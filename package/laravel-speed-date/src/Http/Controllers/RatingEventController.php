<?php

namespace Bunker\LaravelSpeedDate\Http\Controllers;

use App\Http\Controllers\Controller;
use Bunker\LaravelSpeedDate\Enums\EventTypeEnum;
use Bunker\LaravelSpeedDate\Models\DatingEvent;
use Bunker\LaravelSpeedDate\Models\RatingEvent;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class RatingEventController extends Controller
{
    public function __construct()
    {
        // Middleware to ensure user authentication
        $this->middleware('auth');

        // Middleware to authorize access based on permissions for specific methods
        $this->middleware('permission:sd_rating_show|sd_rating_create|sd_rating_edit|sd_rating_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sd_rating_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sd_rating_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sd_rating_delete', ['only' => ['destroy']]);
    }
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = DatingEvent::all();

        return view('speed_date::events.index', compact('events'));
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'user_email' => 'required|exists:users,email',
            'event' => 'required|exists:dating_events,id',
            'rating' => 'required|in:yes,no,maybe'
        ]);
        $userTo = User::where('email', $request->get('user_email'))->first();
        // Create new rating
        $ratingEvent = RatingEvent::where([
            'user_id_from' => auth()->id(),
            'user_id_to' => $userTo->id,
            'event_id' => $request->event_id,
        ])->first();
        
        if ($ratingEvent) {
            // If the record already exists, update it with the new rating
            $ratingEvent->update(['rating' => $request->rating]);
        } else {
            // If the record doesn't exist, create a new one
            RatingEvent::create([
                'user_id_from' => auth()->id(),
                'user_id_to' => $userTo->id,
                'event_id' => $request->event_id,
                'rating' => $request->rating
            ]);
        }

        return redirect()->back()->with('success', "Saved ratings successfully");
    }
}
