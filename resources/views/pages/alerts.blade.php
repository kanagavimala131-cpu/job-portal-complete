@extends('layouts.app')

@section('title', 'Job Alerts')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            @include('partials.sidebar')
        </div>
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><i class="fas fa-bell me-2 text-danger"></i>Job Alerts</h4>
                </div>
                <div class="card-body">
                    @if(isset($alerts) && count($alerts) > 0)
                        @foreach($alerts as $alert)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>{{ $alert['title'] }}</h5>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary">{{ $alert['count'] }} new jobs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                            <h5>No Job Alerts</h5>
                            <p class="text-muted">You haven't created any job alerts yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection