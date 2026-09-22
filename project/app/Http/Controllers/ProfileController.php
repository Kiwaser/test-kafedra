<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'fio' => $user->fio,
                'avatar' => $user->avatar,
                'email' => $user->email,
            ],
        ], 200);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'fio' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,'.$request->user()->id],
            'password' => ['sometimes', 'required', 'string', 'min:6'],
            'avatar' => ['sometimes', 'nullable', 'string'],
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $request->user()->update($data);

        return response()->json(['message' => 'data updated successfully'], 200);
    }
}
