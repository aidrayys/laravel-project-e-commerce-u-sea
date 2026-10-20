@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="seller-header">
        <div class="seller-info">
            <h1>Admin Dashboard</h1>
            <p>U-Sea Administration Panel</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline">Logout</button>
        </form>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Users</div>
            <div class="summary-value">{{ $stats['users'] }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Products</div>
            <div class="summary-value">{{ $stats['products'] }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Categories</div>
            <div class="summary-value">{{ $stats['categories'] }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Orders</div>
            <div class="summary-value">{{ $stats['orders'] }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Total Sales</div>
            <div class="summary-value">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="dashboard-card" style="margin-top: 1.5rem;">
        <h2>Access Granted</h2>
        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Anda berhasil mengakses halaman admin sebagai <strong>{{ auth()->user()->role }}</strong>.</p>
        <p>Role Anda telah terverifikasi oleh middleware admin. Customer dan seller tanpa role admin tidak dapat membuka halaman ini.</p>
    </div>
@endsection
