<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Construct the RoleController class with middleware and permissions.
     */
    public function __construct()
    {
        // Middleware to ensure user authentication
        $this->middleware('auth');

        // Middleware to authorize access based on permissions for specific methods
        $this->middleware('permission:role_show|role_create|role_edit|role_delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Role $role): View|\Illuminate\Foundation\Application|Factory|Application
    {
        // Return view with paginated roles
        return view('pages.roles.index', ['roles' => $role->orderBy('id', 'ASC')->paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store a new role and sync its permissions
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'New roles is added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return view with permissions for role creation
        return view('pages.roles.create', ['permissions' => Permission::orderby('id', 'ASC')->get()->toArray()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View|\Illuminate\Foundation\Application|Factory|Application
    {
        // Show role details with its associated permissions
        $rolePermissions = $role->permissions()->select('name')->get();

        return view('pages.roles.show', ['role' => $role, 'rolePermissions' => $rolePermissions]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Prevent editing of the 'Super Admin' role
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        // Retrieve role permissions for editing
        $rolePermissions = $role->permissions()->pluck('id')->all();

        return view('pages.roles.edit', ['role' => $role, 'permissions' => Permission::orderby('id', 'ASC')->get()->toArray(), 'rolePermissions' => $rolePermissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): \Illuminate\Http\RedirectResponse
    {
        // Update role information and sync permissions
        $input = $request->only('name');
        $role->update($input);
        $permissions = Permission::whereIn('id', $request->input('permissions'))->get(['name'])->toArray();
        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Role is updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of 'Super Admin' role, self-assigned role, or roles with associated users
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        if ($role->users->isNotEmpty()) {
            abort(403, 'First remove users who have this ROLE!');
        }
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role is deleted successfully.');
    }

}
