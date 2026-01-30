<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response|mixed
    {
        try {
            return WebResponse::success(Inertia::render('Profile/Edit', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
            ]));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse|mixed
    {
        try {
            return WebResponse::success(DB::transaction(function () use ($request) {
                $request->user()->fill($request->validated());

                if ($request->user()->isDirty('email')) {
                    $request->user()->email_verified_at = null;
                }

                $request->user()->save();

                return Redirect::route('profile.edit');
            }));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse|mixed
    {
        try {
            $request->validate([
                'password' => ['required', 'current_password'],
            ]);

            return WebResponse::success(DB::transaction(function () use ($request) {
                $user = $request->user();

                Auth::logout();

                $user->delete();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return Redirect::to('/');
            }));
        } catch (\Exception $e) {
            return WebResponse::error($e, true);
        }
    }
}
