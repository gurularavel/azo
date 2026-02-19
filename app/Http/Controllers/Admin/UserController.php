<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with(['activeSubscription.plan'])
            ->orderBy('name')
            ->paginate(12);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $isSuperAdmin = auth()->user()->role === 'superadmin';

        $rules = [
            'is_blocked'      => ['required', 'boolean'],
            'usage_remaining' => ['nullable', 'integer', 'min:0'],
        ];

        if ($isSuperAdmin) {
            $rules['role'] = ['required', 'in:user,admin,superadmin'];
        }

        $data = $request->validate($rules);

        $userFields = ['is_blocked' => $data['is_blocked']];

        if ($isSuperAdmin && isset($data['role'])) {
            $userFields['role']     = $data['role'];
            $userFields['is_admin'] = in_array($data['role'], ['admin', 'superadmin']);
        }

        $user->update($userFields);

        if (($data['usage_remaining'] ?? null) !== null) {
            $subscription = $user->activeSubscription()->first();
            if ($subscription) {
                $subscription->update(['usage_remaining' => $data['usage_remaining']]);
            }
        }

        return redirect()->route('admin.users.index')->with('status', __('messages.user_updated'));
    }
}
