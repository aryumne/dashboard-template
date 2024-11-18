<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function updateProfilePicture(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($request->hasFile('profile_pict')) {
            $request->validate([
                'profile_pict' => ['required', 'image', File::image()->max('3mb')]
            ]);
            $file           = $request->file('profile_pict');
            $originalName   = $user->name;
            $extension      = $file->getClientOriginalExtension();
            $datetime       = now()->format('YmdHis');
            $fileName       = $originalName . '-' . $datetime . '.' . $extension;
            $path           = $file->storeAs('avatars', $fileName);
            $user->profile_pict = $path;
            $user->save();
            Cache::forget('top-contributors');
            return back()->with('success', "Profie Picture updated Succesfully, please refresh to see the changes.");
        }
        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
