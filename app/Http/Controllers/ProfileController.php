<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,'.$request->user()->id],
                // ^ It can be current user's own current phone number (if no change)
        ];

        $user = $request->user();

        if (!$user->isOauthUser()) {
            $rules['email'] = ['required', 'email', 'unique:users,email,'.$user->id];
            // ^ It can be current user's own current email (if no change requested)
        }

        $data = $request->validate($rules);

        $user->fill($data);

        $success = 'Your profile was updated.';

        if ($user->isDirty('email')) { // isDirty checks if email property was changed
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $success = 'Email Verification was sent. Please check your email inbox.';
        }

        $user->save();
        return redirect()->route('profile.index')->with('success', $success);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed',
                Password::min(8)
                ->max(32)
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised()
                ],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated succesfully.');
    }
}
