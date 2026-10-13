<nav class="navbar">
    <div class="container navbar-inner">
        <a href="{{ route('home') }}" class="logo" aria-label="U-Sea Home">
            <svg viewBox="0 0 210 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M16 50 Q36 38 56 50 Q76 62 96 50" stroke="#18AEE5" stroke-width="4" stroke-linecap="round" fill="none"/>
                <ellipse cx="48" cy="28" rx="22" ry="15" fill="#087EA4"/>
                <path d="M26 28 L8 14 L8 42 Z" fill="#087EA4"/>
                <circle cx="62" cy="24" r="4" fill="white"/>
                <circle cx="64" cy="24" r="2" fill="#0B1F3A"/>
                <path d="M36 36 Q42 40 48 36" stroke="rgba(255,255,255,0.6)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                <text x="78" y="42" font-family="Segoe UI, sans-serif" font-size="30" font-weight="800" fill="#0B1F3A">U-Sea</text>
            </svg>
        </a>

        <form action="{{ route('products.index') }}" method="GET" class="nav-search" role="search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5z" fill="currentColor"/>
                <path d="M9.5 14a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" fill="currentColor"/>
            </svg>
            <input type="text"
                   name="search"
                   placeholder="Search seafood, UMKM, or fisherman..."
                   value="{{ request('search') }}"
                   aria-label="Search">
        </form>

        @php
            $cartCount = collect(session('cart', []))->sum('quantity');
        @endphp

        <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')" aria-label="Toggle menu">
            &#9776;
        </button>

        <ul class="nav-links">
            <li>
                <a href="{{ route('home') }}">
                    <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" fill="currentColor"/>
                    </svg>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('products.index') }}">
                    <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2C7 2 3 6 3 11s4 9 9 9c2 0 4-.5 5.5-1.5v-2c-1.5.8-3.2 1.3-5 1.3-4.4 0-8-3.6-8-8s3.6-8 8-8c1.8 0 3.5.5 5 1.3V2.5C16 2.2 14 2 12 2zm6 6.5l3-2v5l-3-2v-1zm-6 2c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5S13.4 10.5 12 10.5z" fill="currentColor"/>
                    </svg>
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cart.index') }}" class="cart-link">
                    <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" fill="currentColor"/>
                    </svg>
                    <span>Cart</span>
                    @if ($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </li>
            @if (session('seller_logged_in'))
                <li>
                    <a href="{{ route('seller.dashboard') }}">
                        <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" fill="currentColor"/>
                        </svg>
                        <span>Seller Center</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('seller.logout') }}" method="POST" style="display: contents;">
                        @csrf
                        <button type="submit">
                            <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('seller.login') }}">
                        <svg class="nav-link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" fill="currentColor"/>
                        </svg>
                        <span>Login</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
