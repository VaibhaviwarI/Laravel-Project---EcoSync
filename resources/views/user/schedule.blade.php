@extends('layouts.app')

@section('title', 'Schedules - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Sanitation Cleaning Schedules</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Monitor the campus weekly sanitation calendar and view live planned cleanups</p>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: 1.5fr 1fr; gap: 2rem; margin-bottom: 3rem;">
    <!-- Weekly Sanitation Schedule Table -->
    <div class="glass-panel reports-panel" style="padding: 1.5rem;">
        <h3 class="panel-title" style="color: var(--secondary); margin-bottom: 1.25rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Weekly Campus Cleanup Timetable
        </h3>
        
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Coverage Area</th>
                        <th>Target Items</th>
                        <th>Shift Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 700; color: var(--primary);">Monday</td>
                        <td>Block A (Admin) & Main Dining Hall</td>
                        <td>Dry Recyclables & General Waste</td>
                        <td>Morning (08:00 - 11:30)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; color: var(--primary);">Tuesday</td>
                        <td>Block B (Sciences) & Chemistry Labs</td>
                        <td>Hazardous Waste & Chemical Residues</td>
                        <td>Afternoon (14:00 - 17:00)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; color: var(--primary);">Wednesday</td>
                        <td>Campus Grounds & Central Library</td>
                        <td>Organic Composting & Litter Sweeping</td>
                        <td>Morning (09:00 - 12:00)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; color: var(--primary);">Thursday</td>
                        <td>Block C (Hostels) & Cafeteria</td>
                        <td>General Garbage & Bin Emptying</td>
                        <td>Evening (16:30 - 19:30)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 700; color: var(--primary);">Friday</td>
                        <td>Engineering Wings & IT Labs</td>
                        <td>Electronic Waste (E-Waste) Pickups</td>
                        <td>Morning (10:00 - 13:00)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Live planned cleanups side widgets -->
    <div class="glass-panel reports-panel" style="padding: 1.5rem;">
        <h3 class="panel-title" style="color: var(--primary); margin-bottom: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><polyline points="12 6 12 12 16 14"/></svg>
            Active Cleanup Tasks
        </h3>
        <p style="color: var(--text-secondary); font-size: 0.82rem; margin-bottom: 1.25rem;">Live tracking of cleaning staff assigned to reported complaints</p>

        @if($activeSchedules->isEmpty())
            <div style="text-align: center; padding: 2rem; color: var(--text-secondary); font-size: 0.88rem;">
                No active planned cleanups scheduled at this moment.
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($activeSchedules as $task)
                    <div class="glass-panel" style="padding: 1rem; background: rgba(255,255,255,0.015); border-color: rgba(255,255,255,0.04);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-weight: 700; font-size: 0.9rem; color: var(--secondary);">{{ $task->category }}</span>
                            <span class="badge badge-{{ $task->status === 'resolved' ? 'resolved' : 'progress' }}" style="font-size: 0.7rem;">
                                {{ $task->status === 'resolved' ? 'Completed' : 'In Progress' }}
                            </span>
                        </div>
                        <div style="font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                            <strong>Location:</strong> {{ $task->location }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.35rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Staff: <strong>{{ $task->assigned_staff ?? 'Assigned Team' }}</strong></span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
