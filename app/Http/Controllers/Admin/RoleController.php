<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Role;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RoleOptionResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->pluck('name');
        $roles = Role::all();
        $rows = RoleOptionResource::collection($roles);
        return Inertia::render('Admin/Role/Index', compact('rows', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($request->permissions);
            return back()->with('success', "Role created Succesfully.");
        } catch (Throwable $e) {
            Log::error("Error on creating role", ['error' => $e->getMessage()]);
            return back()->withInput()->with('failed', "Internal server error!")->withInput();
        }
    }

    public function update(Request $request, $uuid)
    {
        $role = Role::find($uuid);
        if (!$role) return abort(404);
        if (in_array($role->name, ['superadmin'])) {
            return back()->with('failed', "This role is not permitted to update!");
        }
        $rules = [];
        if ($request->has('name'))              $rules['name']          = ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role)];
        if ($request->has('permissions'))       $rules['permissions']   = ['required', 'array'];
        $request->validate($rules);
        try {
            isset($request->name) && $role->name = $request->name;
            $role->save();
            isset($request->permissions) && $role->syncPermissions($request->permissions);
            return back()->with('success', "Role updated Succesfully.");
        } catch (Throwable $e) {
            Log::error("Error on updating role", ['error' => $e->getMessage()]);
            return back()->withInput()->with('failed', "Internal server error!")->withInput();
        }
    }
}
