@extends('layouts.app')

@section('title', 'Applied Jobs')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Applied Jobs</h4>
                </div>
                <div class="card-body">
                    @if(isset($jobs) && count($jobs) > 0)
                        @foreach($jobs as $job)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>{{ $job['title'] }}</h5>
                                            <p class="text-muted">{{ $job['company'] }}</p>
                                        </div>
                                        <div>
                                            <span class="badge bg-info">{{ $job['status'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                            <h5>No Applications Yet</h5>
                            <p class="text-muted">Jobs you apply for will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection