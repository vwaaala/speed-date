<?php

namespace Bunker\LaravelSpeedDate\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Bunker\LaravelSpeedDate\Enums\EventTypeEnum;
use Bunker\LaravelSpeedDate\Models\DatingEvent;
use Bunker\LaravelSpeedDate\Models\RatingEvent;
use Bunker\LaravelSpeedDate\Models\UserBio;
use Bunker\LaravelSpeedDate\Notifications\VoteComplete;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class DatingEventController extends Controller
{
    public function __construct()
    {
        // Middleware to ensure user authentication
        $this->middleware('auth');

        // Middleware to authorize access based on permissions for specific methods
        $this->middleware('permission:sd_event_show|sd_event_create|sd_event_edit|sd_event_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sd_event_create', ['only' => ['create', 'store', 'uploadUsers']]);
        $this->middleware('permission:sd_event_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sd_event_delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $searchQuery = '';
        if (auth()->user()->hasRole('User')) {
            $authUser = auth()->user();
            if ($request->has('search')) {
                $searchQuery = $request->search;
                $events = DatingEvent::whereHas('participants', function ($query) use ($user) {
                    // Condition for filtering by participant
                    $query->where('users.id', $user->id);
                })->where(function ($query) use ($searchQuery) {
                        // Condition for searching event names
                        $query->where('dating_events.name', 'like', '%' . $searchQuery . '%');
                    })->orderBy('created_at', 'desc')->paginate(10);
            } else {
                // If no search parameter, fetch all permissions with pagination
                $events = DatingEvent::whereHas('participants', function ($query) use ($authUser) {
                    $query->where('users.id', $authUser->id);
                })->orderBy('created_at', 'desc')->paginate(10);
            }
        } else {
            if ($request->has('search')) {
                $searchQuery = $request->search;
                $events = DatingEvent::where('name', 'like', '%' . $searchQuery . '%')->paginate(10);
            } else {
                // If no search parameter, fetch all permissions with pagination
                $events = DatingEvent::orderBy('created_at', 'desc')->paginate(10);

            }
        }

        return view('speed_date::events.index', compact('events', 'searchQuery'));
    }

    public function store(Request $request)
    {

        $request->validate(['name' => 'required|string', 'happens_on' => 'required|date:Y-m-d H:m', 'type' => 'required|in:' . implode(',', EventTypeEnum::toArray()), 'status' => 'required|boolean']);
        $event = DatingEvent::create(['name' => $request->get('name'), 'happens_on' => $request->get('happens_on'), 'type' => $request->get('type'), 'status' => $request->get('status'),]);
        if ($event) {
            return redirect()->route('speed_date.events.index')->with('success', 'Event created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create event.');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('speed_date::events.create');
    }

    public function show(DatingEvent $event): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        if (auth()->user()->hasRole('User') && !$event->participants->contains(auth()->user())) {
            abort(403);
        }
        return view('speed_date::events.show', compact('event'));
    }

    public function edit(DatingEvent $event): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('speed_date::events.edit', compact('event'));
    }

    public function uploadUsers(Request $request): RedirectResponse
    {
        // Validate the CSV file
        $request->validate(['csv_file' => 'required|mimes:csv,txt|max:2048', 'event' => 'required']);

        $event = DatingEvent::findOrfail($request->get('event'));
        // Check if the file is present
        if ($request->hasFile('csv_file')) {
            // Get the file from the request
            $file = $request->file('csv_file');

            // Open the file for reading
            $handle = fopen($file, 'r');

            // Check if the file opened successfully
            if ($handle !== false) {
                // Read each line of the file
                while (($data = fgetcsv($handle)) !== false) {
                    // Extract data from the CSV row
                    list($name, $email, $password, $nickname, $lastname, $city, $occupation, $phone, $birthdate, $gender, $looking_for) = $data;

                    // Check if the user with this email already exists
                    $existingUser = User::where('email', $email)->first();

                    if ($existingUser) {
                        // Update user details
                        $existingUser->update(['name' => $name, 'password' => bcrypt($password)]);
                        $existingUser->bio->update(['nickname' => $nickname, 'lastname' => $lastname, 'city' => $city, 'occupation' => $occupation, 'phone' => $phone, 'birthdate' => $birthdate, 'gender' => $gender, 'looking_for' => $looking_for]);
                        $event->participants()->syncWithoutDetaching($existingUser->id);
                    } else {
                        // Create a new user
                        $newUser = User::create(['uuid' => str()->uuid(), 'name' => $name, 'email' => $email, 'password' => bcrypt($password)]);
                        UserBio::create(['user_id' => $newUser->id, 'nickname' => $nickname, 'lastname' => $lastname, 'city' => $city, 'occupation' => $occupation, 'phone' => $phone, 'birthdate' => $birthdate, 'gender' => $gender, 'looking_for' => $looking_for]);
                        $event->participants()->syncWithoutDetaching($newUser->id);
                        $newUser->assignRole('User');
                    }
                }

                // Close the file handle
                fclose($handle);

                return redirect()->back()->with('success', 'Users imported successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to open the file');
            }
        } else {
            return redirect()->back()->with('error', 'No file uploaded');
        }
    }

    public function update(DatingEvent $event, Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string', 'happens_on' => 'required|date:Y-m-d H:m', 'type' => 'required|in:' . implode(',', EventTypeEnum::toArray()), 'status' => 'required|boolean']);

        $event->update($request->all());

        return redirect()->route('speed_date.events.index')->with('success', 'Event updated successfully.');
    }

    // csv uploads insert bulk user in specific event

    public function destroy(DatingEvent $event)
    {
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }

    public function removeParticipant($eventId, $userId)
    {
        $event = DatingEvent::findOrfail($eventId);
        $event->participants()->detach($userId);

        return redirect()->back()->with('success', 'Removed participant successfully.');
    }
    function finalizeEvent($eventId)
    {
        // Get all participants of the event
        $participants = DatingEvent::findOrFail($eventId)->matchedParticipants;
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
                return redirect()->route('speed_date.events.index')->with('error', 'Vote is not finished yet.');
            }
        }

        foreach ($participants as $participant) {
            $validUsers = $participant->getValidRatingsForEvent($eventId);
            Notification::route('mail', $participant->email)->notify(new VoteComplete($validUsers, $participant));
            if(auth()->user()->id == 1){
                Notification::route('mail', auth()->user()->email)->notify(new VoteComplete($validUsers, $participant));
            }
        }


        return redirect()->route('speed_date.events.index')->with('success', 'Vote completed and notifications sent.');
    }
}
