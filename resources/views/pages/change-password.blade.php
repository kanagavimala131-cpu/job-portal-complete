@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-key me-2 text-primary"></i>Change Password</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.update') }}" style="max-width: 400px;">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="fw-bold">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="fw-bold">New Password</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="fw-bold">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection