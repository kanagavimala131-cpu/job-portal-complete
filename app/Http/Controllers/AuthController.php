<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPersonalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $user->last_login = now();
            $user->login_attempts = 0;
            $user->save();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login successful! Welcome back.');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

   public function register(Request $request)
{
    $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'required|email|unique:login_credentials',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    UserPersonalDetail::create([
        'user_id' => $user->id,
        'fullname' => $request->fullname,
        'email' => $request->email,
        // Add all required fields with defaults
        'date_of_birth' => '2000-01-01',
        'gender' => 'female',
        'work_status' => 'experience',
        'total_experience_years' => 0,
        'total_experience_months' => 0,
        'current_salary' => 0,
        'notice_period' => 'Notice Required',
        'phone' => '0000000000',
        'current_city' => 'City',
        'current_area' => 'Area'
    ]);

    Auth::login($user);

    return redirect()->route('dashboard')
        ->with('success', 'Registration successful! Welcome to Job Portal.');
}
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Logged out successfully');
    }
}