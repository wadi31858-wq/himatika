<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();
        $totalActive = User::where('is_active', true)->count();

        return view('admin.users.index', compact('users', 'totalActive'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        ActivityLog::record(
            'create',
            'Menambahkan akun admin baru: ' . $user->name . ' (' . $user->email . ')',
            $user
        );

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'required|boolean',
        ]);

        // Protection: Cannot deactivate the last active admin
        if (!$validated['is_active'] && $user->is_active) {
            $activeCount = User::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return back()->withInput()->with('error', 'Gagal: Tidak dapat menonaktifkan akun admin terakhir yang aktif di sistem.');
            }
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::record(
            'update',
            'Memperbarui data admin: ' . $user->name . ' (' . $user->email . ')',
            $user
        );

        return redirect()->route('admin.users.index')->with('success', 'Data akun admin berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        // Protection: cannot deactivate the last active admin
        if ($user->is_active) {
            $activeCount = User::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return redirect()->route('admin.users.index')->with('error', 'Peringatan: Tidak dapat menonaktifkan admin terakhir yang aktif.');
            }
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::record(
            'status_change',
            'Status admin ' . $user->name . ' diubah menjadi: ' . $statusText,
            $user
        );

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->name} berhasil {$statusText}.");
    }

    public function destroy(User $user)
    {
        // Protection: cannot delete self
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Peringatan: Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        // Protection: cannot delete the last active admin
        if ($user->is_active) {
            $activeCount = User::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return redirect()->route('admin.users.index')->with('error', 'Peringatan: Tidak dapat menghapus admin terakhir yang aktif di sistem.');
            }
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        ActivityLog::record(
            'delete',
            "Menghapus akun admin: {$name} ({$email})",
            null
        );

        return redirect()->route('admin.users.index')->with('success', "Akun admin {$name} berhasil dihapus.");
    }
}

