<div class="list-group list-group-flush sidebar-menu">
    <!-- Skills Pie Chart -->
    <div class="skills-section p-3">
        <h6 class="fw-bold mb-3"><i class="fas fa-chart-pie me-2 text-primary"></i>Skills Percentage</h6>
        <div class="pie-chart-container text-center mb-2">
            <div class="pie-chart" style="width: 120px; height: 120px; margin: 0 auto; background: conic-gradient(#3498db 0deg 306deg, #e9ecef 306deg 360deg); border-radius: 50%; position: relative;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                    {{ $userDetails->skills_percentage ?? 85 }}%
                </div>
            </div>
        </div>
        <p class="small text-muted text-center mb-0">Upload cover image to increase</p>
    </div>

    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i>Personal Details
    </a>
    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile') ? 'active' : '' }}">
        <i class="fas fa-id-card me-2"></i>My Profile
    </a>
    <a href="{{ route('shortlisted') }}" class="list-group-item list-group-item-action {{ request()->routeIs('shortlisted') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>Shortlisted Jobs
        <span class="badge bg-warning float-end">{{ Auth::user()->shortlistedJobs->count() }}</span>
    </a>
    <a href="{{ route('applied') }}" class="list-group-item list-group-item-action {{ request()->routeIs('applied') ? 'active' : '' }}">
        <i class="fas fa-check-circle me-2"></i>Applied Jobs
        <span class="badge bg-success float-end">{{ Auth::user()->appliedJobs->count() }}</span>
    </a>
    <a href="{{ route('alerts') }}" class="list-group-item list-group-item-action {{ request()->routeIs('alerts') ? 'active' : '' }}">
        <i class="fas fa-bell me-2"></i>Job Alerts
        <span class="badge bg-danger float-end">{{ Auth::user()->jobAlerts->count() }}</span>
    </a>
    <a href="{{ route('cv') }}" class="list-group-item list-group-item-action {{ request()->routeIs('cv') ? 'active' : '' }}">
        <i class="fas fa-file-alt me-2"></i>CV & Cover Letter
    </a>
    <a href="{{ route('change-password') }}" class="list-group-item list-group-item-action {{ request()->routeIs('change-password') ? 'active' : '' }}">
        <i class="fas fa-key me-2"></i>Change Password
    </a>
    <a href="#" class="list-group-item list-group-item-action text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </a>
</div>