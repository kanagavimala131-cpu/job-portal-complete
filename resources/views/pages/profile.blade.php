@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-id-card me-2 text-primary"></i>My Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($userDetails->profile_photo)
                                <img src="{{ Storage::url($userDetails->profile_photo) }}" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.jpg') }}" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr><th>Full Name</th><td>{{ $userDetails->fullname }}</td></tr>
                                <tr><th>Email</th><td>{{ $userDetails->email }}</td></tr>
                                <tr><th>Date of Birth</th><td>{{ $userDetails->date_of_birth ? $userDetails->date_of_birth->format('d-m-Y') : '-' }}</td></tr>
                                <tr><th>Gender</th><td>{{ ucfirst($userDetails->gender) }}</td></tr>
                                <tr><th>Work Status</th><td>{{ ucfirst($userDetails->work_status) }}</td></tr>
                                <tr><th>Experience</th><td>{{ $userDetails->total_experience_years }} years {{ $userDetails->total_experience_months }} months</td></tr>
                                <tr><th>Current Salary</th><td>Rs. {{ number_format($userDetails->current_salary) }}</td></tr>
                                <tr><th>Phone</th><td>{{ $userDetails->phone }}</td></tr>
                                <tr><th>Location</th><td>{{ $userDetails->current_city }}, {{ $userDetails->current_area }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection