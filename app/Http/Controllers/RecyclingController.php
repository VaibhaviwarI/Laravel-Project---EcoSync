<?php

namespace App\Http\Controllers;

use App\Models\RecyclingRequest;
use App\Models\User;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecyclingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        $requests = RecyclingRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get top 10 users for the Leaderboard
        $leaderboard = User::where('role', 'user')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();

        return view('user.recycle', compact('requests', 'leaderboard'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        $data = $request->validate([
            'material_type' => ['required', 'string'],
            'estimated_weight' => ['required', 'numeric', 'min:0.1'],
        ]);

        RecyclingRequest::create([
            'user_id' => Auth::id(),
            'material_type' => $data['material_type'],
            'estimated_weight' => $data['estimated_weight'],
            'status' => 'pending',
            'points_awarded' => 0,
        ]);

        return redirect()->route('user.recycle')->with('success', 'Your recycling collection request has been submitted.');
    }

    public function education()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('user.education');
    }

    public function showRedeem()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $redemptions = Redemption::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.redeem', compact('redemptions'));
    }

    public function claimRedeem(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $data = $request->validate([
            'item_name' => ['required', 'string'],
            'points_spent' => ['required', 'integer', 'min:1'],
        ]);

        if ($user->points < $data['points_spent']) {
            return redirect()->route('user.redeem')->with('error', 'Insufficient Eco-Points! Keep recycling to earn more.');
        }

        $user->decrement('points', $data['points_spent']);

        $voucherCode = 'ECO-' . strtoupper(bin2hex(random_bytes(3)));

        Redemption::create([
            'user_id' => $user->id,
            'item_name' => $data['item_name'],
            'points_spent' => $data['points_spent'],
            'voucher_code' => $voucherCode,
        ]);

        return redirect()->route('user.redeem')->with('success', "Success! Claimed '{$data['item_name']}'. Your claim voucher code is: {$voucherCode}");
    }
}
