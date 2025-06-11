<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function datatable(Request $request)
    {
        $users = User::all();
        $data = $users->map(function ($user, $i) {
            return [
                'no' => $i + 1,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status ?? 'active',
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function updateRole(Request $request, User $user)
    {
        $user->role = $request->role;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }
}
