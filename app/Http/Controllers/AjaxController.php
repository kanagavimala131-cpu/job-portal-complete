<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password'
        ], 401);
    }

    public function checkEmail(Request $request)
    {
        $exists = DB::table('login_credentials')
            ->where('email', $request->email)
            ->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function checkPasswordStrength(Request $request)
    {
        $password = $request->password;
        $strength = 0;
        
        if (strlen($password) >= 8) $strength++;
        if (preg_match('/[A-Z]/', $password)) $strength++;
        if (preg_match('/[a-z]/', $password)) $strength++;
        if (preg_match('/[0-9]/', $password)) $strength++;
        if (preg_match('/[@$!%*?&]/', $password)) $strength++;
        
        return response()->json(['strength' => $strength]);
    }
}