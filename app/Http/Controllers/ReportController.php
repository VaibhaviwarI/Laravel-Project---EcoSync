<?php

namespace App\Http\Controllers;

use App\Models\SanitationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $reports = SanitationReport::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate some statistics for this user's dashboard view
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status', 'pending')->count();
        $inProgressReports = $reports->where('status', 'in_progress')->count();
        $resolvedReports = $reports->where('status', 'resolved')->count();

        return view('user.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports'
        ));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $data = $request->validate([
            'category' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
        ]);

        SanitationReport::create([
            'user_id' => Auth::id(),
            'category' => $data['category'],
            'location' => $data['location'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Your sanitation report has been submitted successfully.');
    }
}
