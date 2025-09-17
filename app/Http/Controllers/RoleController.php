<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        // Get all named routes for the dropdown
        $routes = collect(\Route::getRoutes())->filter(fn($r) => $r->getName() !== null);

        return view('roles', compact('roles', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required|string',
            'allowed_pages' => 'required|array',
        ]);

        Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'allowed_pages' => json_encode($request->allowed_pages ?? []),
        ]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    public function destroy(Role $role)
    {
        if(!$role->default) {
            $role->delete();
        }

        return redirect()->back()->with('success', 'Role deleted successfully!');
    }
}
