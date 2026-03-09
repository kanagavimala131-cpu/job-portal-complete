@extends('layouts.app')

@section('title', 'Shortlisted Jobs')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-star me-2 text-warning"></i>Shortlisted Jobs</h4>
                </div>
                <div class="card-body">
                    @forelse($shortlistedJobs as $job)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5>{{ $job->job_title }}</h5>
                                <p>{{ $job->company }} - {{ $job->location }}</p>
                                <small>Shortlisted on: {{ $job->shortlisted_date->format('d M Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No shortlisted jobs</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection