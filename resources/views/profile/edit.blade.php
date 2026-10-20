@extends('layouts.app')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 1024px) {
        .profile-grid {
            grid-template-columns: 280px 1fr;
        }
    }

    .profile-sidebar {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        height: fit-content;
        text-align: center;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        background: linear-gradient(135deg, var(--seafoam) 0%, var(--light-blue) 100%);
        color: var(--ocean);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.5rem;
        font-weight: 800;
    }

    .profile-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 0.25rem;
    }

    .profile-email {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .profile-role {
        display: inline-block;
        background-color: var(--light-blue);
        color: var(--ocean);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
    }

    .profile-menu {
        list-style: none;
        margin-top: 1.5rem;
        text-align: left;
    }

    .profile-menu li a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: var(--radius);
        color: var(--navy);
        font-weight: 600;
        font-size: 0.95rem;
        transition: background-color 0.2s, color 0.2s;
    }

    .profile-menu li a:hover,
    .profile-menu li a.active {
        background-color: var(--light-blue);
        color: var(--ocean);
    }

    .profile-menu svg {
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
    }

    .profile-card {
        background-color: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .profile-card h2 {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--navy);
        margin-bottom: 1rem;
    }

    .profile-card p {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .profile-card .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .profile-card .saved-message {
        color: var(--success);
        font-size: 0.9rem;
        font-weight: 600;
    }

    .danger-zone {
        border: 1px solid #fee2e2;
        background-color: #fff7ed;
    }
</style>
@endpush

@section('content')
    <h1 class="page-title">Profil Saya</h1>

    <div class="profile-grid">
        <aside class="profile-sidebar">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="profile-role">{{ $user->role }}</div>

            <ul class="profile-menu">
                <li>
                    <a href="{{ route('orders.my') }}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l3.59-3.58L17 12l-5 5z" fill="currentColor"/>
                        </svg>
                        Pesanan Saya
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" fill="currentColor"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: contents;">
                        @csrf
                        <button type="submit" style="width: 100%; background: none; border: none; font: inherit; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: var(--radius); color: var(--navy); font-weight: 600; font-size: 0.95rem;">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <div>
            <div class="profile-card">
                <h2>Informasi Profil</h2>
                <p>Perbarui informasi akun dan data pengiriman Anda.</p>

                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required autocomplete="name">
                        @error('name')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div style="margin-top: 0.5rem; padding: 0.75rem; background-color: var(--light-blue); border-radius: var(--radius); font-size: 0.9rem;">
                                <p>Alamat email Anda belum terverifikasi.</p>
                                <button form="send-verification" class="btn btn-outline btn-small" style="margin-top: 0.5rem;">Kirim ulang email verifikasi</button>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="saved-message" style="margin-top: 0.5rem;">Link verifikasi baru telah dikirim.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor HP</label>
                        <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city" class="form-label">Kota / Kabupaten</label>
                        <input type="text" id="city" name="city" class="form-input" value="{{ old('city', $user->city) }}" placeholder="Contoh: Surabaya">
                        @error('city')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea id="address" name="address" class="form-textarea" placeholder="Jl. Contoh No. 10, Kecamatan...">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        @if (session('status') === 'profile-updated')
                            <span class="saved-message">Profil berhasil diperbarui.</span>
                        @endif
                    </div>
                </form>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
                    @csrf
                </form>
            </div>

            <div class="profile-card">
                <h2>Keamanan</h2>
                <p>Pastikan akun Anda menggunakan password yang kuat.</p>
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-card danger-zone">
                <h2>Hapus Akun</h2>
                <p>Akun yang dihapus tidak dapat dikembalikan. Pastikan Anda telah menyimpan data penting.</p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
