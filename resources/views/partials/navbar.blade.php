<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Incident System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @auth
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-white">{{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-danger" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth

        @auth
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
                Notifications <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>
            <ul class="dropdown-menu">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <li><a class="dropdown-item" href="{{ route('user.incidents.index') }}">{{ $notification->data['message'] }}</a></li>
                @empty
                    <li><span class="dropdown-item">No new notifications</span></li>
                @endforelse
            </ul>
        </li>
        @endauth

        <ul class="navbar-nav me-auto">
            @role('Admin|Super Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.incidents.index') }}">Manage Incidents</a>
            </li>
            @endrole

            @role('Super Admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.users.index') }}">Manage Users</a>
            </li>
            @endrole
        </ul>
    </div>
</nav>
