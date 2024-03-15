<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * This controller handles operations related to the application dashboard.
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply the 'auth' middleware to ensure that only authenticated users can access the dashboard.
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request The HTTP request object.
     * @return Renderable The renderable view representing the application dashboard.
     */
    public function index(Request $request): Renderable
    {
        // Initialize the packet array
        $packet = ['cards'=>[]];

        if(auth()->user()->hasRole('User')){
        } else {
        }

        // Render the dashboard view and pass the packet data
        return view('pages.dashboard', compact('packet'));
    }
}
