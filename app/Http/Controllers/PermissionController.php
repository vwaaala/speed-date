<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Middleware to authorize access only to users with 'permission_show' permission
        $this->middleware('permission:permission_show', ['only' => ['index']]);
    }

    /**
     * Display a listing of the permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Initialize searchQuery variable
        $searchQuery = '';

        // If search parameter exists in the request, filter permissions by name
        if ($request->has('search')) {
            $searchQuery = $request->search;
            $permissions = Permission::where('name', 'like', '%' . $searchQuery . '%')->paginate(10);
        } else {
            // If no search parameter, fetch all permissions with pagination
            $permissions = Permission::paginate(10);
        }
        // Get the current page number
        $currentPage = $permissions->currentPage();

        // Calculate the offset
        $offset = ($currentPage - 1) * $permissions->perPage();

        // Set the paginator current page to adjust the numbering
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        // Return the view with permissions and search query
        return view('pages.permissions.index', compact('permissions', 'searchQuery', 'offset'));
    }
}
