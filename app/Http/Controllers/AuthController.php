<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request): RedirectResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user || $user->password !== $password) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'The user was not found or the data was entered incorrectly']);
        }

        auth()->login($user);

        return redirect()->route('home');
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
