<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function manageUser(): View
    {
        $users = User::all();
        return view('list-user', compact('users'));
    }


    public function edit(Request $request): View
    {
        return view('profile', [
            'user' => $request->user(),
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function editUser($id): View
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role' => ['required', Rule::in(['admin', 'fo', 'accounting', 'manager'])],
        ]);

        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect()->route('user.edit', $user->id)->with('success', 'Data berhasil diubah.');
    }

    public function destroyUser($id)
    {
        $data = User::findOrFail($id);
        if ($data->role == 'admin') {
            return redirect()->back()->with('warning', 'Gagal menghapus user, admin tidak bisa dihapus.');
        }

        $data->delete();
        return redirect()->route('user.manage')->with('success', 'Data berhasil dihapus.');
    }
}
