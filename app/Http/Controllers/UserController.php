<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Bunker\LaravelSpeedDate\Models\DatingEvent;
use Bunker\LaravelSpeedDate\Models\UserBio;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user_create|user_delete', ['only' => ['index']]);
        $this->middleware('permission:user_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_edit', ['only' => ['edit', 'update', 'changePassword']]);
        $this->middleware('permission:user_delete', ['only' => ['destroy', 'retrieveDeleted', 'forceDelete']]);
        $this->middleware('permission:user_show|user_create|user_edit|user_delete', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all()->pluck('name');
        } else {
            $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->pluck('name');
        }
        $events = DatingEvent::orderBy('created_at', 'desc')->select('id', 'name')->get();
        return view('pages.users.create', compact('roles', 'events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $newUser = User::create(['uuid' => str()->uuid(), 'name' => $request->input('name'), 'email' => $request->input('email'), 'password' => bcrypt($request->input('password')), 'status' => $request->input('status')]);
        $newUser->assignRole($request->input('role'));

        // If user created successfully
        if ($newUser) {

            // Check if avatar file exists in request
            if ($request->hasFile('avatar')) {
                $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
                $image = $request->file('avatar');

                // Generate a unique filename using the original file extension
                $image_name = uniqid() . '.' . $image->getClientOriginalExtension();

                // Move the file to the desired location
                $image->move(public_path(config('panel.avatar_path')), $image_name);
                $pathAndName = config('panel.avatar_path') . $image_name;
                // Update user avatar
                $newUser->update(['avatar' => $pathAndName]);
            } else {
                // Update user avatar
                $newUser->update(['avatar' => config('panel.avatar')]);
            }
            $event = DatingEvent::findOrFail($request->get('event'));
            $event->participants()->syncWithoutDetaching($event->id);
            UserBio::create(['user_id' => $newUser->id, 'nickname' => $request->get('nickname'), 'lastname' => $request->get('lastname'), 'city' => $request->get('city'), 'occupation' => $request->get('occupation'), 'phone' => $request->get('phone'), 'birthdate' => $request->get('birthdate'), 'gender' => $request->get('gender'), 'looking_for' => $request->get('looking_for')]);
            $event->participants()->syncWithoutDetaching($newUser->id);
            return redirect()->route('users.index')->with('success', 'User created successfully');
        }
        return redirect()->route('users.index')->with('error', 'Failed to create user.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        if(auth()->user()->id != 1 && auth()->user()->id != $user->id && auth()->user()->canSee($user->id) == false){
            abort('403', 'Access Forbidden!');
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $roles = Role::all()->pluck('name');
        } else {
            $roles = Role::whereNotIn('name', ['Super Admin', 'Admin'])->pluck('name');
        }
        $events = DatingEvent::orderBy('created_at', 'desc')->select('id', 'name')->get();
        if (auth()->user()->id == $user->id && auth()->user()->hasPermissionTo('user_edit')) {
            $roles = [];
            $events = [];
        }
        return view('pages.users.edit', compact('user', 'roles', 'events'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if(auth()->check()){
            if ($user->update(['name' => $request->get('name'), 'status' => $request->get('status') != null ? $request->get('status') : $user->status])) {
                // Check if avatar file exists in requestW
                if ($request->hasFile('avatar')) {
                    $image = $request->file('avatar');
                    // Generate a unique filename using the original file extension
                    $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
    
                    // Move the file to the desired location
                    $image->move(public_path(config('panel.avatar_path')), $image_name);
                    $pathAndName = config('panel.avatar_path') . $image_name;
                    if ($user->avatar != config('panel.avatar')) {
                        try {
                            unlink($user->avatar);
                        } catch (Exception $e){

                        }
                    }
                    // Update user avatar
                    $user->update(['avatar' => $pathAndName]);
                } else {
                    $user->update(['avatar' => config('panel.avatar')]);
                }
                // let admin change user email only
                if(auth()->user()->id == 1 && auth()->user()->id != $user->id){
                    $request->validate([
                        'email' => [
                            'email',
                            Rule::unique('users')->ignore($user->id),
                        ],
                    ]);
                    $user->update(['email' => $request->get('email')]);
                    $event = DatingEvent::findOrFail($request->get('event'));
                    $event->participants()->syncWithoutDetaching($event->id);
                }
                if(auth()->user()->id != 1){
                    $eventid = $user->events->pluck('id')->first();
                    return redirect()->route('speed_date.events.show', $eventid)->with('success', 'Profile updated successfully');
                }
                return redirect()->route('users.index')->with('success', 'User updated successfully');
            }
            return redirect()->back()->with('error', 'Failed to update user ');
        }
        
        return redirect()->route('users.index')->with('error', 'Can not update user!');
    }
    public function updatebio(Request $request, $userid): RedirectResponse
    {
        $user = User::where('id', $userid)->first();
        if(auth()->user()->hasRole('User') && auth()->user()->id != $user->id){
            dd('Hello');
//            abort(403, 'You are not authorized');
        }
        if ($user->bio->update(['nickname' => $request->get('nickname'), 'lastname' => $request->get('lastname'),'city' => $request->get('city'),'occupation' => $request->get('occupation'),'phone' => $request->get('phone'),'birthdate' => $request->get('birthdate'),'gender' => $request->get('gender'),'looking_for' => $request->get('looking_for')])) {
            if(auth()->user()->hasRole('User')){
                return redirect()->route('users.show', $user->id)->with('success', 'User Bio updated successfully');
            }
            return redirect()->route('users.index')->with('success', 'User Bio updated successfully');
        }
        return redirect()->route('users.index')->with('error', 'Can not update user bio!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): Factory|\Illuminate\Foundation\Application|View|Application|RedirectResponse
    {
        if ((auth()->user()->id == 1 || (auth()->user()->id != 1  && auth()->user()->id != $user->id && auth()->user()->canSee($user->id)) || auth()->user()->id == $user->id)) {
            return view('pages.users.view', compact('user'));
        }
        return redirect()->back()->with('error', 'You are not authorized to view the user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    // Permanently remove the specified resource from storage.
    public function forceDelete($userId): RedirectResponse
    {
        // Find soft deleted user
        $restoreUser = User::onlyTrashed()->findOrFail($userId);
        if ($restoreUser) {
            $avatar = $restoreUser->avatar;
            // Permanently delete user
            if ($restoreUser->forceDelete()) {
                // If user had an avatar, delete its file
                if ($avatar != config('panel.avatar')) {
                    try {
                        unlink(public_path($avatar));
                    } catch (Exception $e){
                        
                    }
                }
                return redirect()->route('users.index')->with('success', 'User deleted successfully!');
            }
            return redirect()->route('users.index')->with('error', 'User can not be force deleted');
        }
        return redirect()->route('users.index')->with('error', 'User not found');
    }

    // Restore the specified soft deleted resource.
    public function retrieveDeleted($userId): RedirectResponse
    {
        // Restore soft deleted user
        if (User::withTrashed()->findOrFail($userId)->restore()) {
            return redirect()->back()->with('success', 'User retrieved successfully');
        }
        return redirect()->back()->with('error', 'User can not be retrieved');
    }

    public function changePassword(Request $request, $userId): RedirectResponse
    {
        // Validate the request
        $request->validate(['password' => 'required|min:6|confirmed']);
        $user = User::findOrFail($userId);
        // Check if authenticated user is authorized to change password for the user
        if ($user->update(['password' => bcrypt($request->input('password'))])) {
            // Redirect back or show a success message
            return redirect()->route('users.show', $user->id)->with('success', 'Password changed successfully.');
        }
        return redirect()->route('users.show', $user->id)->with('error', 'Password can not be changed.');
    }

    public function isUserInEvent(User $user){

    }

}

