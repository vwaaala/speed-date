<?php

namespace App\Http\Controllers\Auth;

use App\Events\QueuedEmailVerificationEvent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | users that recently registered with the application. Emails may also
    | be re-sent if the users didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        // Your existing verification logic...

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            // Email is already verified
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new QueuedEmailVerificationEvent($user)); // Dispatch your custom queuable event
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

}
