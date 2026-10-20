@extends('layouts.app')

@push('styles')
<style>
    .auth-page-centered {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        min-height: calc(100vh - 220px);
        padding: 2rem 1rem;
    }

    .auth-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 2rem;
        width: 100%;
        max-width: 440px;
        border: 1px solid var(--seafoam);
    }

    .auth-card-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--navy);
        text-align: center;
    }

    .auth-card-subtitle {
        color: var(--gray);
        font-size: 0.95rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .auth-toggle {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--seafoam);
        text-align: center;
        color: var(--gray);
        font-size: 0.875rem;
    }

    .auth-toggle button {
        background: none;
        border: none;
        padding: 0;
        color: var(--ocean);
        font-weight: 700;
        cursor: pointer;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .auth-toggle button:hover {
        color: var(--ocean-dark);
    }

    .auth-form {
        display: none;
    }

    .auth-form.active {
        display: block;
    }

    @media (min-width: 640px) {
        .auth-page-centered {
            align-items: center;
            padding: 3rem 1rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="auth-page-centered">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
@endsection
