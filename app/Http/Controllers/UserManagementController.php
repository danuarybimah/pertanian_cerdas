<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::whereIn('role', ['petani', 'penyuluh'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('dinas.users.index', compact('users', 'search'));
    }

    public function updateRole(Request $request, int|string $id)
    {
        $user = User::findOrFail($id);

        // Validasi input role
        $data = $request->validate([
            'role' => ['required', Rule::in(['petani', 'penyuluh'])],
        ]);

        // Mencegah perubahan jika target adalah dinas (keamanan ganda)
        if ($user->role === 'dinas') {
            return redirect()->back()->with('error', 'Peran akun Dinas Pertanian tidak dapat diubah.');
        }

        $oldRole = $user->role_label;
        $user->role = $data['role'];
        $user->save();

        $newRole = $user->role_label;

        return redirect()->back()->with('success', "Berhasil mengubah peran \"{$user->name}\" dari {$oldRole} menjadi {$newRole}.");
    }
}
