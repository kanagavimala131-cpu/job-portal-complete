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
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
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
                                        <input type="text" class="form-control @error('fullname') is-invalid @enderror" 
                                               name="fullname" value="{{ old('fullname', $userDetails->fullname) }}" required>
                                        @error('fullname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Date of Birth *</label>
                                        <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                               name="dob" value="{{ old('dob', $userDetails->date_of_birth ? $userDetails->date_of_birth->format('Y-m-d') : '') }}" required>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Gender *</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $userDetails->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $userDetails->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="transgender" {{ old('gender', $userDetails->gender) == 'transgender' ? 'selected' : '' }}>Transgender</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Work Status *</label>
                                        <select class="form-control @error('work_status') is-invalid @enderror" name="work_status" required>
                                            <option value="">Select Status</option>
                                            <option value="fresher" {{ old('work_status', $userDetails->work_status) == 'fresher' ? 'selected' : '' }}>Fresher</option>
                                            <option value="experience" {{ old('work_status', $userDetails->work_status) == 'experience' ? 'selected' : '' }}>Experience</option>
                                        </select>
                                        @error('work_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="fw-bold">Experience (Years) *</label>
                                        <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                               name="experience_years" value="{{ old('experience_years', $userDetails->total_experience_years) }}" min="0" max="15" required>
                                        @error('experience_years')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Experience (Months) *</label>
                                        <input type="number" class="form-control @error('experience_months') is-invalid @enderror" 
                                               name="experience_months" value="{{ old('experience_months', $userDetails->total_experience_months) }}" min="0" max="11" required>
                                        @error('experience_months')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Current Salary (Rs.) *</label>
                                        <input type="number" class="form-control @error('current_salary') is-invalid @enderror" 
                                               name="current_salary" value="{{ old('current_salary', $userDetails->current_salary) }}" min="0" required>
                                        @error('current_salary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">Phone Number *</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               name="phone" value="{{ old('phone', $userDetails->phone) }}" maxlength="10" pattern="[0-9]{10}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Notice Period *</label>
                                        <input type="text" class="form-control @error('notice_period') is-invalid @enderror" 
                                               name="notice_period" value="{{ old('notice_period', $userDetails->notice_period) }}" required>
                                        @error('notice_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold">City *</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               name="city" value="{{ old('city', $userDetails->current_city) }}" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold">Area/Town *</label>
                                        <input type="text" class="form-control @error('area') is-invalid @enderror" 
                                               name="area" value="{{ old('area', $userDetails->current_area) }}" required>
                                        @error('area')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="fw-bold">Facebook</label>
                                        <input type="text" class="form-control" name="facebook" value="{{ old('facebook', $userDetails->facebook_url) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">Twitter</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ old('twitter', $userDetails->twitter_url) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold">LinkedIn</label>
                                        <input type="text" class="form-control" name="linkedin" value="{{ old('linkedin', $userDetails->linkedin_url) }}">
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

@push('scripts')
<script>
$(document).ready(function() {
    // Phone number validation - only numbers
    $('input[name="phone"]').on('keyup', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
    
    // Experience validation
    $('input[name="experience_years"]').on('change', function() {
        if(this.value < 0) this.value = 0;
        if(this.value > 15) this.value = 15;
    });
    
    $('input[name="experience_months"]').on('change', function() {
        if(this.value < 0) this.value = 0;
        if(this.value > 11) this.value = 11;
    });
    
    // Photo preview
    $('#profilePhoto').on('change', function() {
        const file = this.files[0];
        if(file) {
            if(file.size > 1048576) {
                alert('File size must be less than 1MB');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection