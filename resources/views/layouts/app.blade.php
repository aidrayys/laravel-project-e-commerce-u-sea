<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'U-Sea') | From the Sea, Direct to You</title>
    <style>
        :root {
            --navy: #0f172a;
            --ocean: #0ea5e9;
            --ocean-dark: #0284c7;
            --cyan: #06b6d4;
            --light-blue: #f0f9ff;
            --white: #ffffff;
            --gray: #64748b;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 0.75rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-blue);
            color: var(--navy);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        /* Navbar */
        .navbar {
            background-color: var(--navy);
            color: var(--white);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--cyan);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo span {
            color: var(--white);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--cyan);
        }

        .cart-badge {
            background-color: var(--ocean);
            color: var(--white);
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            margin-left: 0.25rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--navy);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background-color: var(--ocean);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--ocean-dark);
        }

        .btn-navy {
            background-color: var(--navy);
            color: var(--white);
        }

        .btn-navy:hover {
            opacity: 0.9;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--ocean);
            border: 2px solid var(--ocean);
        }

        .btn-outline:hover {
            background-color: var(--ocean);
            color: var(--white);
        }

        .btn-danger {
            background-color: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            opacity: 0.9;
        }

        .btn-small {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.375rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #cbd5e1;
            border-radius: var(--radius);
            font-size: 1rem;
            background-color: var(--white);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--ocean);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Alert messages */
        .alert {
            padding: 0.875rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .validation-error {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Cards */
        .card {
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #e0f2fe;
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-category {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ocean-dark);
            margin-bottom: 0.5rem;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-price {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .card-meta {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .card-actions {
            margin-top: auto;
            padding-top: 1rem;
        }

        /* Product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Search bar */
        .search-bar {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .search-bar {
                flex-direction: row;
            }
        }

        .search-bar .form-input,
        .search-bar .form-select {
            flex: 1;
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--ocean-dark) 100%);
            color: var(--white);
            padding: 4rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            text-align: center;
        }

        .hero-label {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .hero-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .hero-text {
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto 1.5rem;
            opacity: 0.9;
        }

        @media (min-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
        }

        /* Section title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Product detail */
        .product-detail {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        @media (min-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr 1fr;
            }
        }

        .product-detail img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: var(--radius);
            background-color: #e0f2fe;
        }

        .product-info h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .product-info .price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--ocean-dark);
            margin-bottom: 1rem;
        }

        .product-info .meta {
            margin-bottom: 0.5rem;
            color: var(--gray);
        }

        .quantity-input {
            width: 80px;
            text-align: center;
        }

        /* Cart */
        .cart-table {
            width: 100%;
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .cart-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-table th {
            background-color: #f8fafc;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            color: var(--gray);
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
            background-color: #e0f2fe;
        }

        .cart-actions-cell {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        @media (max-width: 767px) {
            .cart-table thead {
                display: none;
            }

            .cart-table tr {
                display: block;
                border-bottom: 1px solid #e2e8f0;
                padding: 1rem;
            }

            .cart-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: none;
                padding: 0.5rem 0;
            }

            .cart-table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--gray);
                font-size: 0.875rem;
            }
        }

        .cart-summary {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            max-width: 400px;
            margin-left: auto;
        }

        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .cart-summary-row.total {
            font-size: 1.25rem;
            font-weight: 700;
            border-top: 2px solid #e2e8f0;
            padding-top: 0.75rem;
        }

        /* Checkout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .checkout-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .checkout-card h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-item:last-of-type {
            border-bottom: none;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.25rem;
            font-weight: 700;
            border-top: 2px solid #e2e8f0;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        /* Order success */
        .order-success {
            max-width: 600px;
            margin: 2rem auto;
            background-color: var(--white);
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            text-align: center;
        }

        .order-success .icon {
            width: 80px;
            height: 80px;
            background-color: #dcfce7;
            color: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
        }

        .order-success h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .order-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--ocean-dark);
            margin: 1rem 0;
        }

        .status-badge {
            display: inline-block;
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state h2 {
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem;
            color: var(--gray);
            font-size: 0.875rem;
            margin-top: 2rem;
        }

        /* Responsive nav */
        @media (max-width: 767px) {
            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--navy);
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            .nav-links.active {
                display: flex;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                U-Sea <span>Marketplace</span>
            </a>

            @php
                $cartCount = count(session('cart', []));
            @endphp

            <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')" aria-label="Toggle menu">
                &#9776;
            </button>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li>
                    <a href="{{ route('cart.index') }}">
                        Cart
                        @if ($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} U-Sea. From the Sea, Direct to You.
    </footer>

    @stack('scripts')
</body>
</html>
