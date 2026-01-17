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
     * Display a public user profile.
     */
    public function show($userId): View
    {
        $user = \App\Models\User::findOrFail($userId);
        $statistic = $user->getStatistic();
        
        // Get privacy settings
        $privacy = $user->getLeaderboardPrivacy();
        
        // Get completed bookings with mountains (only if privacy allows)
        $mountainHistory = null;
        $uniqueMountains = collect();
        
        if ($privacy['show_mountain_history']) {
            $mountainHistory = $user->bookings()
                ->whereIn('status', ['completed', 'checked_in'])
                ->with(['mountain', 'trailRoute'])
                ->orderBy('check_in_date', 'desc')
                ->get();
            
            // Get unique mountains climbed
            $uniqueMountains = $mountainHistory
                ->unique('mountain_id')
                ->pluck('mountain');
        }
        
        // Calculate total spent (only if privacy allows)
        $totalSpent = null;
        if ($privacy['show_total_spent']) {
            $totalSpent = $statistic->total_spent ?? 0;
        }
        
        // Get user photos
        $photos = $user->photos;
        
        return view('profile.show', compact(
            'user',
            'statistic',
            'privacy',
            'mountainHistory',
            'uniqueMountains',
            'totalSpent',
            'photos'
        ));
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

        return Redirect::route('profile.edit')->with('profile_updated', 'Profile information has been updated successfully!');
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
        
        return Redirect::route('profile.edit')->with('member_added', 'Member data has been saved successfully!');
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
        
        return Redirect::route('profile.edit')->with('member_deleted', 'Member data has been deleted successfully!');
    }

    /**
     * Update leaderboard privacy settings.
     */
    public function updatePrivacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'show_total_spent' => 'required|boolean',
            'show_mountain_history' => 'required|boolean',
            'show_email' => 'required|boolean',
        ]);

        $user = $request->user();
        $user->leaderboard_privacy = $validated;
        $user->save();

        return Redirect::route('profile.edit')->with('privacy_updated', 'Privacy settings updated successfully!');
    }

    /**
     * Upload a new photo to user gallery.
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // max 5MB
            'caption' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        
        // Store the photo
        $path = $request->file('photo')->store('user-photos', 'public');
        
        // Get the next order number
        $maxOrder = $user->photos()->max('order') ?? 0;
        
        // Create photo record
        $user->photos()->create([
            'photo_path' => $path,
            'caption' => $request->caption,
            'location' => $request->location,
            'order' => $maxOrder + 1,
        ]);

        return Redirect::route('profile.show', $user->id)->with('photo_uploaded', 'Photo uploaded successfully!');
    }

    /**
     * Delete a photo from user gallery.
     */
    public function deletePhoto(\App\Models\UserPhoto $photo): RedirectResponse
    {
        // Check if the photo belongs to the authenticated user
        if ($photo->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the photo file from storage
        if (Storage::disk('public')->exists($photo->photo_path)) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        // Delete the photo record
        $photo->delete();

        return Redirect::route('profile.show', Auth::id())->with('photo_deleted', 'Photo deleted successfully!');
    }
}