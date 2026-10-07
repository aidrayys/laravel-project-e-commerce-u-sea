@extends('layouts.app')

@section('title', 'Seller Login')

@push('styles')
<style>
    .seller-login-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 2rem;
        max-width: 420px;
        margin: 2rem auto;
        text-align: center;
    }

    .seller-login-card h1 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--navy);
    }

    .seller-login-card p {
        color: var(--gray);
        margin-bottom: 1.5rem;
    }

    .demo-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px dashed var(--ocean);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .demo-box-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--ocean);
        margin-bottom: 0.75rem;
    }

    .demo-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .demo-row:last-child {
        margin-bottom: 0;
    }

    .demo-label {
        font-weight: 600;
        color: var(--navy);
    }

    .demo-value {
        font-family: monospace;
        background-color: var(--white);
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid #bae6fd;
        color: var(--ocean-dark);
    }
</style>
@endpush

@section('content')
    <div class="seller-login-card">
        <h1>Seller Center</h1>
        <p>Masuk ke dashboard penjual U-Sea.</p>

        <div class="demo-box">
            <div class="demo-box-title">Demo Account</div>
            <div class="demo-row">
                <span class="demo-label">Username</span>
                <span class="demo-value">pesisirrasa</span>
            </div>
            <div class="demo-row">
                <span class="demo-label">Password</span>
                <span class="demo-value">123</span>
            </div>
        </div>

        <form action="{{ route('seller.login.submit') }}" method="POST">
            @csrf

            <div class="form-group" style="text-align: left;">
                <label for="username" class="form-label">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       class="form-input"
                       value="pesisirrasa"
                       required
                       autofocus>
            </div>

            <div class="form-group" style="text-align: left;">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="form-input"
                       value="123"
                       required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>
    </div>
@endsection
