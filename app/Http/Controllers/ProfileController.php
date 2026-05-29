<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'wilayah'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->wilayah = $data['wilayah'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
