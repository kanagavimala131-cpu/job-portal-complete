@extends('layouts.app')

@section('title', 'CV & Cover Letter')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar', ['userDetails' => $userDetails])
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-file-alt me-2 text-primary"></i>CV & Cover Letter</h4>
                    <div>
                        <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#uploadCvModal">
                            <i class="fas fa-upload me-2"></i>Upload CV
                        </button>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCoverLetterModal">
                            <i class="fas fa-plus me-2"></i>Add Cover Letter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- CV Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-pdf text-danger me-2"></i>My CV / Resume
                            </h5>
                        </div>
                        
                        @if(isset($cvFiles) && count($cvFiles) > 0)
                            @foreach($cvFiles as $cv)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">{{ $cv['name'] }}</h6>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-weight-hanging me-1"></i>{{ $cv['size'] }} | 
                                                        <i class="fas fa-calendar me-1"></i>{{ date('d M Y', strtotime($cv['uploaded_at'])) }}
                                                    </small>
                                                    @if(isset($cv['version']))
                                                        <small class="text-muted">Version: {{ $cv['version'] }}</small>
                                                    @endif
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('cv.download', $cv['id']) }}">
                                                                <i class="fas fa-download me-2"></i>Download
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('delete-cv-{{ $cv['id'] }}').submit();">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                            <form id="delete-cv-{{ $cv['id'] }}" action="{{ route('cv.delete', $cv['id']) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center py-4 bg-light rounded">
                                    <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                                    <h6>No CV Uploaded</h6>
                                    <p class="text-muted small">Upload your resume to apply for jobs</p>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadCvModal">
                                        <i class="fas fa-upload me-2"></i>Upload CV
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Cover Letters Section -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-word text-primary me-2"></i>Cover Letters
                            </h5>
                        </div>
                        
                        @if(isset($coverLetters) && count($coverLetters) > 0)
                            @foreach($coverLetters as $letter)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-file-word fa-3x text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">{{ $letter['name'] }}</h6>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-building me-1"></i>{{ $letter['company'] ?? 'General' }}
                                                        @if(isset($letter['position']))
                                                            | {{ $letter['position'] }}
                                                        @endif
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>{{ date('d M Y', strtotime($letter['uploaded_at'])) }}
                                                    </small>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fas fa-download me-2"></i>Download
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('delete-cover-{{ $letter['id'] }}').submit();">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                            <form id="delete-cover-{{ $letter['id'] }}" action="{{ route('coverletter.delete', $letter['id']) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center py-4 bg-light rounded">
                                    <i class="fas fa-file-word fa-3x text-muted mb-3"></i>
                                    <h6>No Cover Letters</h6>
                                    <p class="text-muted small">Create cover letters for job applications</p>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadCoverLetterModal">
                                        <i class="fas fa-plus me-2"></i>Add Cover Letter
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Tips Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-lightbulb fa-2x"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="alert-heading">Pro Tips for Better Applications</h6>
                                        <ul class="mb-0 small">
                                            <li>Keep your CV updated with latest experience</li>
                                            <li>Customize cover letter for each job application</li>
                                            <li>Use PDF format for better compatibility</li>
                                            <li>File size should be less than 5MB</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload CV Modal -->
<div class="modal fade" id="uploadCvModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload CV / Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('cv.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="cv_file" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Allowed: PDF, DOC, DOCX (Max 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Version (Optional)</label>
                        <input type="text" class="form-control" name="version" placeholder="e.g., v2.0, Updated March 2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Cover Letter Modal -->
<div class="modal fade" id="uploadCoverLetterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Cover Letter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('coverletter.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="cover_letter_file" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Allowed: PDF, DOC, DOCX (Max 5MB)</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" name="company" placeholder="e.g., Tech Solutions">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position" placeholder="e.g., PHP Developer">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush
@endsection