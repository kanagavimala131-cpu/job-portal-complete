@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="auth-card">
                <div class="logo-placeholder">
                    <i class="fas fa-briefcase me-2"></i>JOB BASKETS
                </div>
                <h3 class="text-center mb-4">Login to Your Account</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                @endif
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Email address *</label>
                        <input type="email" class="form-control" id="email" name="email" value="" placeholder="Enter your email" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label">Remember me</label>
                    </div>
                    
                    <div class="mb-3 text-end">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                
                <div class="text-center mt-4">
                    <p>New User? <a href="{{ route('register') }}">Register Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection