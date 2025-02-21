<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $user = Auth::user(); // Get authenticated user
    
        // 🚨 Log User Data for Debugging
        Log::info('Authenticated User:', ['user' => $user]);
    
        if (!$user instanceof \App\Models\User) {
            return response()->json(['error' => 'User object is not recognized', 'data' => $user], 500);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }
    


    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete(); // ✅ Logout by deleting tokens
        return response()->json(['message' => 'Logout successful']);
    }
}
