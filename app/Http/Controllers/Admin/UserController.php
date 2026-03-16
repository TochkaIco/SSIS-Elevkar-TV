<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        $user->is_admin = $request->boolean('is_admin');
        $user->save();

        return to_route('admin.users.index')->with('success', __('User permissions updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return to_route('admin.users.index')->with('error', __('You cannot delete yourself'));
        }

        $user->delete();

        return to_route('admin.users.index')->with('success', __('User deleted'));
    }
}
