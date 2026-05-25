@extends('layouts.app')

@section('title', 'Recycling & Rewards - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Recycling & Eco-Rewards</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Upload recyclables, earn eco-points, and compete on the leaderboard</p>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Recycling request forms & history -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Request Form -->
        <div class="glass-panel form-panel">
            <h3 class="panel-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                Request Recycle Pickup
            </h3>
            
            <form action="{{ route('recycle.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="material_type" class="form-label">Material Type</label>
                    <select name="material_type" id="material_type" class="form-control" required>
                        <option value="" disabled selected>Select material</option>
                        <option value="Plastic Bottles / Containers">Plastic Bottles / Containers</option>
                        <option value="Paper & Cardboard">Paper & Cardboard</option>
                        <option value="Metal Cans / Scraps">Metal Cans / Scraps</option>
                        <option value="Glass Bottles">Glass Bottles</option>
                        <option value="Electronic Waste (E-Waste)">Electronic Waste (E-Waste)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="estimated_weight" class="form-label">Estimated Weight (kg)</label>
                    <input type="number" step="0.01" name="estimated_weight" id="estimated_weight" class="form-control" placeholder="e.g. 2.50" required min="0.1">
                    <span style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem; display: block;">You earn <strong>10 points per kg</strong> upon collection approval.</span>
                </div>
                
                <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;">Submit Pickup Request</button>
            </form>
        </div>

        <!-- Recycle Request History -->
        <div class="glass-panel reports-panel" style="padding: 1.5rem;">
            <h3 class="panel-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Recycling History
            </h3>
            
            @if($requests->isEmpty())
                <div style="text-align: center; padding: 2rem; color: var(--text-secondary); font-size: 0.9rem;">
                    No pickup requests registered yet.
                </div>
            @else
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Est. Weight</th>
                                <th>Status</th>
                                <th>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $req)
                                <tr>
                                    <td style="font-weight: 600;">{{ $req->material_type }}</td>
                                    <td>{{ number_format($req->estimated_weight, 2) }} kg</td>
                                    <td>
                                        <span class="badge badge-{{ $req->status === 'pending' ? 'pending' : 'resolved' }}">
                                            {{ $req->status }}
                                        </span>
                                    </td>
                                    <td style="font-family: var(--font-outfit); font-weight: 700; color: {{ $req->status === 'collected' ? 'var(--primary)' : 'var(--text-secondary)' }}">
                                        +{{ $req->points_awarded }} pts
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Leaderboard Panel -->
    <div class="glass-panel leaderboard-panel">
        <h3 class="panel-title" style="margin-bottom: 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2.5"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            Top Recyclers Leaderboard
        </h3>
        <p style="color: var(--text-secondary); font-size: 0.88rem; margin-bottom: 1.5rem;">Eco-pioneers leading the clean campus movement</p>
        
        <div class="leaderboard-list">
            @foreach($leaderboard as $index => $u)
                <div class="leaderboard-item">
                    <div class="leaderboard-user">
                        <div class="rank-badge rank-{{ $index < 3 ? ($index + 1) : 'other' }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ $u->name }}</span>
                            @if(auth()->id() === $u->id)
                                <span style="font-size: 0.75rem; color: var(--primary); font-weight: 700;">You</span>
                            @endif
                        </div>
                    </div>
                    <div class="user-pts">
                        {{ $u->points }} pts
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
