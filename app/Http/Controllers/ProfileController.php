<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'savedMembers' => $request->user()->savedMembers()->latest()->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Store a new saved member.
     */
    public function storeMember(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Validate max 5 members
        if ($user->savedMembers()->count() >= 5) {
            return Redirect::route('profile.edit')->withErrors(['member' => 'Maksimal 5 data anggota dapat disimpan.']);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
        ]);
        
        // Check duplicate ID number for this user
        if ($user->savedMembers()->where('id_number', $validated['id_number'])->exists()) {
            return Redirect::route('profile.edit')->withErrors(['id_number' => 'Nomor identitas sudah terdaftar.']);
        }
        
        $user->savedMembers()->create($validated);
        
        return Redirect::route('profile.edit')->with('success', 'Data anggota berhasil disimpan!');
    }

    /**
     * Delete a saved member.
     */
    public function deleteMember(\App\Models\SavedMember $member): RedirectResponse
    {
        // Verify ownership
        if ($member->user_id !== auth()->id()) {
            abort(403);
        }
        
        $member->delete();
        
        return Redirect::route('profile.edit')->with('success', 'Data anggota berhasil dihapus!');
    }
}
