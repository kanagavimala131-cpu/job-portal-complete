@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm" id="personal-section">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2 text-primary"></i>Personal Details</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('dashboard.update') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="profile-photo mb-3">
                                    @if($userDetails->profile_photo && Storage::disk('public')->exists($userDetails->profile_photo))
                                        <img src="{{ Storage::url($userDetails->profile_photo) }}" 
                                             class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" id="profilePreview">
                                    @else
                                        <img src="{{ asset('images/default-avatar.jpg') }}" 
                                             class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" id="profilePreview">
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="profile_photo" id="profilePhoto" accept=".jpg,.jpeg,.png" class="form-control">
                                    <small class="text-muted">Max 1MB, JPG/PNG only</small>
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Full Name *</label>
                                        <input type="text" class="form-control" name="fullname" value="{{ $userDetails->fullname }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" value="{{ $userDetails->date_of_birth ? $userDetails->date_of_birth->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="male" {{ $userDetails->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $userDetails->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="transgender" {{ $userDetails->gender == 'transgender' ? 'selected' : '' }}>Transgender</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Work Status</label>
                                        <select class="form-control" name="work_status">
                                            <option value="fresher" {{ $userDetails->work_status == 'fresher' ? 'selected' : '' }}>Fresher</option>
                                            <option value="experience" {{ $userDetails->work_status == 'experience' ? 'selected' : '' }}>Experience</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="fw-bold">Experience (Years)</label>
                                        <input type="number" class="form-control" name="experience_years" value="{{ $userDetails->total_experience_years }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Experience (Months)</label>
                                        <input type="number" class="form-control" name="experience_months" value="{{ $userDetails->total_experience_months }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Current Salary</label>
                                        <input type="number" class="form-control" name="current_salary" value="{{ $userDetails->current_salary }}">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $userDetails->phone }}" maxlength="10">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Notice Period</label>
                                        <input type="text" class="form-control" name="notice_period" value="{{ $userDetails->notice_period }}">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">City</label>
                                        <input type="text" class="form-control" name="city" value="{{ $userDetails->current_city }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Area</label>
                                        <input type="text" class="form-control" name="area" value="{{ $userDetails->current_area }}">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="fw-bold">Facebook</label>
                                        <input type="text" class="form-control" name="facebook" value="{{ $userDetails->facebook_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Twitter</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ $userDetails->twitter_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">LinkedIn</label>
                                        <input type="text" class="form-control" name="linkedin" value="{{ $userDetails->linkedin_url }}">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection