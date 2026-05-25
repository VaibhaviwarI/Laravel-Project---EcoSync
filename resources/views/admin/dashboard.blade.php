@extends('layouts.app')

@section('title', 'Admin Dashboard - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Admin Monitoring Panel</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Monitor sanitation issues, assign cleaning staff, and approve recycling rewards</p>
    </div>
</div>

<!-- Admin Metrics Grid -->
<div class="stats-grid">
    <div class="glass-panel stat-card">
        <div class="stat-label">Total Complaints</div>
        <div class="stat-value">{{ $totalReports }}</div>
    </div>
    <div class="glass-panel stat-card accent">
        <div class="stat-label">Active Issues</div>
        <div class="stat-value">{{ $pendingReports + $inProgressReports }}</div>
    </div>
    <div class="glass-panel stat-card secondary">
        <div class="stat-label">Recycling Pickups</div>
        <div class="stat-value">{{ $totalRecycles }}</div>
    </div>
    <div class="glass-panel stat-card">
        <div class="stat-label">Total Points Distributed</div>
        <div class="stat-value" style="color: var(--primary);">{{ $totalPointsAwarded }} pts</div>
    </div>
</div>

<!-- Dynamic Charts Grid -->
<div class="admin-grid">
    <div class="glass-panel chart-card">
        <h4 style="margin-bottom: 1rem; color: var(--primary); font-family: var(--font-outfit);">Reports by Category</h4>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div class="glass-panel chart-card">
        <h4 style="margin-bottom: 1rem; color: var(--secondary); font-family: var(--font-outfit);">Sanitation Status Progress</h4>
        <div class="chart-container">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Tabbed tables or split layouts -->
<div style="display: flex; flex-direction: column; gap: 2.5rem; margin-top: 1rem;">
    <!-- Sanitation Issue Assignment Center -->
    <div class="glass-panel reports-panel" style="padding: 1.50rem;">
        <h3 class="panel-title" style="color: var(--secondary); margin-bottom: 1.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            Sanitation Issue Assignment & Status Center
        </h3>

        @if($reports->isEmpty())
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                No sanitation reports submitted by students yet.
            </div>
        @else
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Assign Cleaner / Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td style="font-weight: 600;">{{ $report->user->name }}</td>
                                <td style="color: var(--primary);">{{ $report->category }}</td>
                                <td>{{ $report->location }}</td>
                                <td style="max-width: 260px; font-size: 0.88rem; color: var(--text-secondary);">{{ $report->description }}</td>
                                <td>
                                    <span class="badge badge-priority-{{ $report->priority }}">{{ $report->priority }}</span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.reports.status', $report->id) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                                        @csrf
                                        <input type="text" name="assigned_staff" class="form-control" style="padding: 0.35rem 0.5rem; font-size: 0.82rem; width: 120px;" placeholder="Staff Name" value="{{ $report->assigned_staff }}">
                                        
                                        <select name="status" class="admin-select">
                                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $report->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>

                                        <button type="submit" class="btn btn-primary" style="padding: 0.35rem 0.75rem; font-size: 0.82rem; width: auto; border-radius: 6px;">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Recycling Rewards Approvals -->
    <div class="glass-panel reports-panel" style="padding: 1.50rem;">
        <h3 class="panel-title" style="color: var(--primary); margin-bottom: 1.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
            Recycling Collection Approvals & Eco-Rewards
        </h3>

        @if($recycles->isEmpty())
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                No recycling requests submitted by students yet.
            </div>
        @else
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Material Type</th>
                            <th>Est. Weight</th>
                            <th>Status</th>
                            <th>Awarded Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recycles as $recycle)
                            <tr>
                                <td style="font-weight: 600;">{{ $recycle->user->name }}</td>
                                <td>{{ $recycle->material_type }}</td>
                                <td>{{ number_format($recycle->estimated_weight, 2) }} kg</td>
                                <td>
                                    <span class="badge badge-{{ $recycle->status === 'pending' ? 'pending' : 'resolved' }}">
                                        {{ $recycle->status }}
                                    </span>
                                </td>
                                <td style="font-family: var(--font-outfit); font-weight: 700; color: {{ $recycle->status === 'collected' ? 'var(--primary)' : 'var(--text-secondary)' }}">
                                    {{ $recycle->points_awarded > 0 ? "+{$recycle->points_awarded} pts" : '--' }}
                                </td>
                                <td>
                                    @if($recycle->status === 'pending')
                                        <form action="{{ route('admin.recycle.approve', $recycle->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="padding: 0.35rem 1rem; font-size: 0.82rem; width: auto; border-radius: 6px;">Approve & Reward</button>
                                        </form>
                                    @else
                                        <span style="color: var(--primary); font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.25rem;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            Collected & Rewarded
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Styling parameters
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.font.family = 'Inter';

    // 1. Categories Chart
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    const categories = {!! json_encode($chartCategories) !!};
    const categoryCounts = {!! json_encode($chartCategoryCounts) !!};

    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: categories.length > 0 ? categories : ['No Data'],
            datasets: [{
                data: categoryCounts.length > 0 ? categoryCounts : [1],
                backgroundColor: [
                    '#10b981', '#06b6d4', '#f59e0b', '#ef4444', '#8b5cf6', '#6b7280'
                ],
                borderColor: '#0b0f19',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            },
            cutout: '70%'
        }
    });

    // 2. Status Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    const statuses = {!! json_encode($chartStatuses) !!};
    const statusCounts = {!! json_encode($chartStatusCounts) !!};

    new Chart(ctxStatus, {
        type: 'bar',
        data: {
            labels: statuses,
            datasets: [{
                label: 'Issues Count',
                data: statusCounts,
                backgroundColor: ['#f59e0b', '#06b6d4', '#10b981'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection
