<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class SessionsUserController extends Controller
{
    //
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'failed to connect to fetch your data from Google');
        }
        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
        ]);

        if ($user->email === config('app.maintainer_admin_email') && ! $user->is_admin) {
            $user->update(['is_admin' => true]);
        }

        Auth::login($user);

        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
