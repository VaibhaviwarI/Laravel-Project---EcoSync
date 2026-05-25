<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EcoSync - Smart Waste & Sanitation Management')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        @auth
        <nav class="navbar">
            <a href="{{ url('/') }}" class="nav-brand">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                EcoSync
            </a>
            
            <ul class="nav-links">
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Admin Dashboard</a></li>
                @else
                    <li><a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Reports</a></li>
                    <li><a href="{{ route('user.recycle') }}" class="nav-link {{ request()->routeIs('user.recycle') ? 'active' : '' }}">Recycling & Rewards</a></li>
                    <li><a href="{{ route('user.education') }}" class="nav-link {{ request()->routeIs('user.education') ? 'active' : '' }}">Education & Awareness</a></li>
                @endif
            </ul>

            <div class="nav-user">
                @if(auth()->user()->role === 'user')
                    <div class="points-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                        <span>{{ auth()->user()->points }} Eco-Points</span>
                    </div>
                @else
                    <div class="points-badge" style="border-color: var(--secondary);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Administrator</span>
                    </div>
                @endif
                
                <span style="font-weight: 500; font-family: var(--font-outfit);">{{ auth()->user()->name }}</span>
                
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.85rem; width: auto; border-radius: 8px;">Logout</button>
                </form>
            </div>
        </nav>
        @endauth

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>
