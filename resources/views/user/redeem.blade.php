@extends('layouts.app')

@section('title', 'Redeem Rewards - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Eco-Rewards Store</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Spend your earned Eco-Points on beautiful eco-friendly goods and campus vouchers</p>
    </div>
</div>

<!-- Rewards Catalog -->
<div class="edu-grid" style="margin-bottom: 3rem;">
    <!-- Coffee -->
    <div class="glass-panel edu-item" style="border-color: rgba(6,182,212,0.15); text-align: left; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div class="edu-icon-container" style="margin: 0 0 1rem; background: rgba(6, 182, 212, 0.1); border-color: rgba(6, 182, 212, 0.2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            </div>
            <h4 class="edu-title" style="color: var(--secondary); font-size: 1.3rem; margin-bottom: 0.5rem;">Free Campus Cafe Brew</h4>
            <p class="edu-desc" style="margin-bottom: 1.5rem;">Get a hot fresh coffee or tea at the Campus Cafe. 100% organic beans.</p>
        </div>
        
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-family: var(--font-outfit);">
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">50 Points</span>
                <span style="color: var(--text-secondary); font-size: 0.85rem;">In Stock: Active</span>
            </div>
            <form action="{{ route('user.redeem.claim') }}" method="POST">
                @csrf
                <input type="hidden" name="item_name" value="Free Campus Cafe Brew">
                <input type="hidden" name="points_spent" value="50">
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);">Claim Voucher</button>
            </form>
        </div>
    </div>

    <!-- Bamboo Mug -->
    <div class="glass-panel edu-item" style="border-color: rgba(16,185,129,0.15); text-align: left; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div class="edu-icon-container" style="margin: 0 0 1rem; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <h4 class="edu-title" style="color: var(--primary); font-size: 1.3rem; margin-bottom: 0.5rem;">Eco Bamboo Mug</h4>
            <p class="edu-desc" style="margin-bottom: 1.5rem;">A reusable coffee mug built with natural sustainable bamboo fiber. BPA free.</p>
        </div>
        
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-family: var(--font-outfit);">
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">150 Points</span>
                <span style="color: var(--text-secondary); font-size: 0.85rem;">In Stock: Limited</span>
            </div>
            <form action="{{ route('user.redeem.claim') }}" method="POST">
                @csrf
                <input type="hidden" name="item_name" value="Eco Bamboo Mug">
                <input type="hidden" name="points_spent" value="150">
                <button type="submit" class="btn btn-primary">Claim Mug</button>
            </form>
        </div>
    </div>

    <!-- Bookstore Voucher -->
    <div class="glass-panel edu-item" style="border-color: rgba(245,158,11,0.15); text-align: left; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div class="edu-icon-container" style="margin: 0 0 1rem; background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
            <h4 class="edu-title" style="color: var(--accent); font-size: 1.3rem; margin-bottom: 0.5rem;">Bookstore $15 Voucher</h4>
            <p class="edu-desc" style="margin-bottom: 1.5rem;">A campus bookstore gift voucher valid for all textbooks and stationery goods.</p>
        </div>
        
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; font-family: var(--font-outfit);">
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">300 Points</span>
                <span style="color: var(--text-secondary); font-size: 0.85rem;">In Stock: High</span>
            </div>
            <form action="{{ route('user.redeem.claim') }}" method="POST">
                @csrf
                <input type="hidden" name="item_name" value="Bookstore $15 Voucher">
                <input type="hidden" name="points_spent" value="300">
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, var(--accent) 0%, var(--danger) 100%); color: #fff;">Claim Voucher</button>
            </form>
        </div>
    </div>
</div>

<!-- Claims History -->
<div class="glass-panel reports-panel">
    <h3 class="panel-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        My Redemption History ({{ $redemptions->count() }})
    </h3>

    @if($redemptions->isEmpty())
        <div style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.4;"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            <p>You have not redeemed any rewards yet. Recycle more to earn Eco-Points!</p>
        </div>
    @else
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Date Redeemed</th>
                        <th>Item Claimed</th>
                        <th>Eco-Points Spent</th>
                        <th>Redemption Voucher Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($redemptions as $claim)
                        <tr>
                            <td>{{ $claim->created_at->format('M d, Y - H:i') }}</td>
                            <td style="font-weight: 600; color: var(--primary);">{{ $claim->item_name }}</td>
                            <td style="font-family: var(--font-outfit); font-weight: 700; color: var(--danger);">-{{ $claim->points_spent }} pts</td>
                            <td>
                                <code style="font-family: monospace; background: rgba(255,255,255,0.06); padding: 0.25rem 0.5rem; border-radius: 4px; color: var(--secondary); font-size: 0.95rem; border: 1px solid rgba(255,255,255,0.08);">{{ $claim->voucher_code }}</code>
                            </td>
                            <td>
                                <span class="badge badge-resolved">Ready to Claim</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
