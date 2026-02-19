<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('id')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.form', [
            'role'     => null,
            'sections' => Role::SECTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:64', 'alpha_dash', 'unique:roles,name'],
            'label'       => ['required', 'string', 'max:128'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        Role::create([
            'name'        => $data['name'],
            'label'       => $data['label'],
            'permissions' => $data['permissions'] ?? [],
            'is_system'   => false,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('status', __('messages.role_saved'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.form', [
            'role'     => $role,
            'sections' => Role::SECTIONS,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'label'         => ['required', 'string', 'max:128'],
            'name'          => ['required', 'string', 'max:64', 'alpha_dash', Rule::unique('roles','name')->ignore($role->id)],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        // System role names cannot be renamed
        $updates = ['label' => $data['label'], 'permissions' => $data['permissions'] ?? []];
        if (!$role->is_system) {
            $updates['name'] = $data['name'];
        }

        $role->update($updates);

        return redirect()->route('admin.roles.index')
            ->with('status', __('messages.role_saved'));
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return back()->with('error', __('messages.role_system_protected'));
        }

        // Demote users of this role to 'user'
        $role->users()->update(['role' => 'user', 'is_admin' => false]);
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('status', __('messages.role_deleted'));
    }
}
