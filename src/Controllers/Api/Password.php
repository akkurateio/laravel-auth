<?php

namespace Akkurate\LaravelAuth\Controllers\Api;

use Akkurate\LaravelCore\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Password
{
    public function update(Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();

        if (empty($user)) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        if ($user->id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthenticated'], 403);
        }

        $validated = $request->validate([
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (Hash::check($validated['old_password'], Hash::make($user->password))) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json(['message' => 'Password was successfully updated'], 200);
        }
        return response()->json(['message' => 'Invalid password'], 404);

    }
}
