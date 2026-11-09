<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // PROFIL DEFAULT
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

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

    // =========================
    // PROFIL ADMIN
    // =========================

    public function editAdmin(Request $request): View
    {
        return view('admin.profil', [
            'user' => $request->user(),
        ]);
    }

    public function updateAdmin(Request $request): RedirectResponse
    {
        return $this->updateProfile(
            $request,
            'admin.profil',
            'Informasi profil berhasil diperbarui.'
        );
    }

    public function updatePasswordAdmin(Request $request): RedirectResponse
    {
        return $this->updateUserPassword(
            $request,
            'admin.profil'
        );
    }

    // =========================
    // PROFIL PETUGAS
    // =========================

    public function editPetugas(Request $request): View
    {
        return view('petugas.profil', [
            'user' => $request->user(),
        ]);
    }

    public function updatePetugas(Request $request): RedirectResponse
    {
        return $this->updateProfile(
            $request,
            'petugas.profil',
            'Informasi profil berhasil diperbarui.'
        );
    }

    public function updatePasswordPetugas(Request $request): RedirectResponse
    {
        return $this->updateUserPassword(
            $request,
            'petugas.profil'
        );
    }

    // =========================
    // PROFIL SISWA
    // =========================

    public function editSiswa(Request $request): View
    {
        $user = $request->user();
        $anggota = $user->anggota;

        abort_unless(
            $anggota,
            403,
            'Data anggota belum terhubung dengan akun siswa.'
        );

        return view('siswa.profil', compact('user', 'anggota'));
    }

    public function updateSiswa(Request $request): RedirectResponse
    {
        $user = $request->user();
        $anggota = $user->anggota;

        abort_unless(
            $anggota,
            403,
            'Data anggota belum terhubung dengan akun siswa.'
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('anggotas', 'email')->ignore($anggota->id),
            ],
            'no_telepon' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($user, $anggota, $validated) {
            $emailBerubah = $user->email !== $validated['email'];

            // Update akun pengguna
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if ($emailBerubah) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Sinkronisasi data anggota
            $anggota->nama = $validated['name'];
            $anggota->email = $validated['email'];
            $anggota->no_telepon = $validated['no_telepon'];
            $anggota->save();
        });

        return Redirect::route('siswa.profil')
            ->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function updatePasswordSiswa(Request $request): RedirectResponse
    {
        return $this->updateUserPassword(
            $request,
            'siswa.profil'
        );
    }

    // =========================
    // METHOD BANTUAN
    // =========================

    private function updateProfile(
        Request $request,
        string $route,
        string $message
    ): RedirectResponse {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route($route)
            ->with('success', $message);
    }

    private function updateUserPassword(
        Request $request,
        string $route
    ): RedirectResponse {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return Redirect::route($route)
            ->with('success', 'Password berhasil diperbarui.');
    }
}