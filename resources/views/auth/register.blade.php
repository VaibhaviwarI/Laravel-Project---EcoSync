@extends('layouts.app')

@section('title', 'Register - EcoSync Smart Waste System')

@section('content')
<div class="auth-wrapper">
    <div class="glass-panel auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 0 10px rgba(16,185,129,0.4));"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <h1 class="auth-title">Join EcoSync</h1>
            <p class="auth-subtitle">Clean environments, earned rewards</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span style="color: var(--danger); font-size: 0.82rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: var(--danger); font-size: 0.82rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                @error('password')
                    <span style="color: var(--danger); font-size: 0.82rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Register</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>
</div>
@endsection
