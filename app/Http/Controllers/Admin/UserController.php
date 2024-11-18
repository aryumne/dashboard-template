<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Admin\RoleOptionResource;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'entries', 'sort_key', 'sort_order']);
        if (isset($filters['entries']) && $filters['entries'] > 100) $filters['entries'] = 100;
        $users = $this->service->getRows($filters);
        $rows = UserResource::collection($users);
        return Inertia::render('Admin/Users/Index', compact('rows', 'filters'));
    }

    public function create()
    {
        $roles = Role::all();
        $roles = RoleOptionResource::collection($roles);
        return Inertia::render('Admin/Users/Create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->service->create($request->all());
            return back()->with('success', "User created Succesfully.");
        } catch (Throwable $e) {
            report($e);
            return back()->withInput()->with('failed', "Internal server error!")->withInput();
        }
    }

    public function edit($uuid)
    {
        $user = $this->service->getById($uuid);
        if (!$user) return abort(404);
        $user = new UserResource($user);
        $roles = Role::all();
        $roles = RoleOptionResource::collection($roles);
        return Inertia::render('Admin/Users/Edit', compact('user', 'roles'));
    }

    public function update(Request $request, $uuid)
    {
        $user = $this->service->getById($uuid);
        if (!$user) return abort(404);
        $rules = [];
        if ($request->has('name'))              $rules['name']          = ['string', 'max:255', Rule::unique('users', 'name')->ignore($user)];
        if ($request->has('password'))          $rules['password']      = ['string', 'max:255'];
        if ($request->has('initial_name'))      $rules['initial_name']  = ['nullable', 'string', 'max:10', Rule::unique('users', 'initial_name')->ignore($user)];
        if ($request->has('email'))             $rules['email']         = ['string', 'max:255', Rule::unique('users', 'email')->ignore($user)];
        if ($request->has('role'))              $rules['role']          = ['string', 'max:255', Rule::exists('roles', 'name')];
        if ($request->has('is_active'))         $rules['is_active']     = ['boolean'];
        if ($request->hasFile('join_date'))     $rules['join_date']     = ['nullable', 'date', 'date_format:Y-m-d'];
        $request->validate($rules);
        try {
            !empty($request->name) && $user->name            = trim($request->name);
            !empty($request->password) && $user->password    = trim($request->password);
            !empty($request->email) && $user->email          = trim($request->email);
            isset($request->is_active) && $user->is_active   = $request->is_active;
            isset($request->join_date) && $user->join_date   = $request->join_date;
            !empty($request->initial_name) && $user->initial_name = strtoupper(trim($request->initial_name));
            isset($request->role) && $user->syncRoles([$request->role]);
            $user->save();
            return back()->with('success', "User updated Succesfully.");
        } catch (Throwable $e) {
            report($e);
            return back()->withInput()->with('failed', "Internal server error!")->withInput();
        }
    }

    public function destroy(Request $request, $uuid)
    {
        try {
            if ($request->user()->id === $uuid) {
                return back()->with('failed', "You cannot destroy your self!");
            }
            $user = User::find($uuid);
            if (!$user) return abort(404);
            $user->is_active = false;
            $user->syncRoles([]);
            $user->save();
            $user->delete();

            return back()->with('success', "User deleted Succesfully.");
        } catch (Throwable $e) {
            report($e);
            return back()->with('failed', "Internal server error!");
        }
    }
}
