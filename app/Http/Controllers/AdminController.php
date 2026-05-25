<?php

namespace App\Http\Controllers;

use App\Models\RecyclingRequest;
use App\Models\SanitationReport;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }
        $reports = SanitationReport::with('user')->orderBy('created_at', 'desc')->get();
        $recycles = RecyclingRequest::with('user')->orderBy('created_at', 'desc')->get();
        $usersCount = User::where('role', 'user')->count();

        // Compute metrics
        $totalReports = $reports->count();
        $resolvedReports = $reports->where('status', 'resolved')->count();
        $pendingReports = $reports->where('status', 'pending')->count();
        $inProgressReports = $reports->where('status', 'in_progress')->count();

        $totalRecycles = $recycles->count();
        $collectedRecycles = $recycles->where('status', 'collected')->count();
        $totalPointsAwarded = User::sum('points');

        // Compile data for Charts (Grouping reports by category)
        $reportsByCategory = $reports->groupBy('category')->map->count();
        $chartCategories = $reportsByCategory->keys()->toArray();
        $chartCategoryCounts = $reportsByCategory->values()->toArray();

        // Compile data for Charts (Report status distribution)
        $chartStatuses = ['Pending', 'In Progress', 'Resolved'];
        $chartStatusCounts = [$pendingReports, $inProgressReports, $resolvedReports];

        // Compile data for Charts (Recycling material types)
        $recyclesByType = $recycles->groupBy('material_type')->map->count();
        $chartMaterials = $recyclesByType->keys()->toArray();
        $chartMaterialCounts = $recyclesByType->values()->toArray();

        return view('admin.dashboard', compact(
            'reports',
            'recycles',
            'usersCount',
            'totalReports',
            'resolvedReports',
            'pendingReports',
            'inProgressReports',
            'totalRecycles',
            'collectedRecycles',
            'totalPointsAwarded',
            'chartCategories',
            'chartCategoryCounts',
            'chartStatuses',
            'chartStatusCounts',
            'chartMaterials',
            'chartMaterialCounts'
        ));
    }

    public function updateReportStatus(Request $request, SanitationReport $report)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }
        $data = $request->validate([
            'status' => ['required', 'string', 'in:pending,in_progress,resolved'],
            'assigned_staff' => ['nullable', 'string', 'max:255'],
        ]);

        $updateData = [
            'status' => $data['status'],
            'assigned_staff' => $data['assigned_staff'] ?? $report->assigned_staff,
        ];

        if ($data['status'] === 'resolved' && $report->status !== 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $report->update($updateData);

        return redirect()->route('admin.dashboard')->with('success', 'Sanitation report updated successfully.');
    }

    public function approveRecycle(Request $request, RecyclingRequest $recycle)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }
        if ($recycle->status === 'collected') {
            return redirect()->route('admin.dashboard')->with('error', 'Recycling request already approved.');
        }

        // Award points based on material and weight: e.g. 10 points per kg
        $points = (int) round($recycle->estimated_weight * 10);

        $recycle->update([
            'status' => 'collected',
            'points_awarded' => $points,
        ]);

        // Add points to user
        $user = $recycle->user;
        $user->increment('points', $points);

        return redirect()->route('admin.dashboard')->with('success', "Recycling collection approved. Awarded $points points to {$user->name}!");
    }
}
