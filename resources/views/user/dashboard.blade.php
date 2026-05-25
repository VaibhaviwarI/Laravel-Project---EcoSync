@extends('layouts.app')

@section('title', 'Sanitation Dashboard - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Sanitation Management</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Report waste and track cleanup status in real time</p>
    </div>
</div>

<div class="stats-grid">
    <div class="glass-panel stat-card">
        <div class="stat-label">Total Reports</div>
        <div class="stat-value">{{ $totalReports }}</div>
    </div>
    <div class="glass-panel stat-card accent">
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $pendingReports }}</div>
    </div>
    <div class="glass-panel stat-card secondary">
        <div class="stat-label">In Progress</div>
        <div class="stat-value">{{ $inProgressReports }}</div>
    </div>
    <div class="glass-panel stat-card">
        <div class="stat-label">Resolved</div>
        <div class="stat-value" style="color: var(--primary);">{{ $resolvedReports }}</div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Report Form Panel -->
    <div class="glass-panel form-panel">
        <h3 class="panel-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Report Trash / Issue
        </h3>
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="" disabled selected>Select category</option>
                    <option value="General Garbage">General Garbage</option>
                    <option value="Overflowing Bin">Overflowing Bin</option>
                    <option value="Recyclables">Recyclables</option>
                    <option value="Hazardous Waste">Hazardous Waste</option>
                    <option value="E-Waste">E-Waste</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location" class="form-label">Specific Location</label>
                <input type="text" name="location" id="location" class="form-control" placeholder="e.g., Block C Corridor, Room 302" required>
            </div>

            <div class="form-group">
                <label for="priority" class="form-label">Priority Level</label>
                <select name="priority" id="priority" class="form-control" required>
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description / Details</label>
                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Describe the issue (e.g. wet garbage spilled, bad odor, needs sweeping...)" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 0.5rem;">Submit Report</button>
        </form>
    </div>

    <!-- Active Reports List Panel -->
    <div class="glass-panel reports-panel">
        <h3 class="panel-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            My Reports ({{ $reports->count() }})
        </h3>
        
        @if($reports->isEmpty())
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.4;"><circle cx="12" cy="12" r="10"/><path d="m9.06 11.94 1.41 1.41 4.47-4.47"/></svg>
                <p>You have not reported any sanitation issues yet.</p>
            </div>
        @else
            <div class="reports-list">
                @foreach($reports as $report)
                    <div class="glass-panel report-item" style="background: rgba(255,255,255,0.015);">
                        <div class="report-header">
                            <div class="report-meta">
                                <span class="report-cat">{{ $report->category }}</span>
                                <span class="report-loc">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $report->location }}
                                </span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <span class="badge badge-priority-{{ $report->priority }}">{{ $report->priority }}</span>
                                <span class="badge badge-{{ $report->status === 'pending' ? 'pending' : ($report->status === 'in_progress' ? 'progress' : 'resolved') }}">
                                    {{ str_replace('_', ' ', $report->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="report-body">
                            {{ $report->description }}
                        </div>

                        <!-- Real-time Status Progression Timeline -->
                        <div class="timeline">
                            <div class="timeline-step {{ $report->status === 'pending' || $report->status === 'in_progress' || $report->status === 'resolved' ? 'pending active' : '' }}">
                                <div class="timeline-node"></div>
                                <span class="timeline-label">Pending</span>
                            </div>
                            <div class="timeline-step {{ $report->status === 'in_progress' || $report->status === 'resolved' ? 'in-progress active' : '' }}">
                                <div class="timeline-node"></div>
                                <span class="timeline-label">In Progress</span>
                            </div>
                            <div class="timeline-step {{ $report->status === 'resolved' ? 'active' : '' }}">
                                <div class="timeline-node"></div>
                                <span class="timeline-label">Resolved</span>
                            </div>
                        </div>

                        @if($report->assigned_staff)
                            <div style="margin-top: 1rem; font-size: 0.82rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.02); padding: 0.5rem 0.75rem; border-radius: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <span>Assigned Cleaner: <strong>{{ $report->assigned_staff }}</strong></span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
