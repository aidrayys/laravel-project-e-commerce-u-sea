<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'U-Sea') | From the Sea, Direct to You</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Cellipse cx='32' cy='32' rx='22' ry='14' fill='%23087EA4'/%3E%3Cpath d='M14 32 L2 20 L2 44 Z' fill='%23087EA4'/%3E%3Ccircle cx='42' cy='28' r='3' fill='white'/%3E%3Ccircle cx='43' cy='28' r='1.5' fill='%230B1F3A'/%3E%3C/svg%3E" type="image/svg+xml">
    <style>
        :root {
            --navy: #0B1F3A;
            --ocean: #087EA4;
            --ocean-dark: #065f7a;
            --cyan: #18AEE5;
            --cyan-light: #7dd3fc;
            --seafoam: #DDF7F5;
            --coral: #f97316;
            --coral-dark: #ea580c;
            --light-blue: #f0f9ff;
            --white: #ffffff;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 0.75rem;
            --radius-lg: 1rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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

        button {
            font-family: inherit;
        }

        /* Utility container - full width with generous padding */
        .container {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 4vw, 3.75rem);
        }

        .container-narrow {
            max-width: 1200px;
        }

        .section {
            padding: 3rem 0;
        }

        .page-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--navy);
        }

        .section-title {
            font-size: clamp(1.25rem, 2.5vw, 1.75rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--navy);
        }

        .section-subtitle {
            color: var(--gray);
            margin-top: -1rem;
            margin-bottom: 1.5rem;
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
            transition: transform 0.1s, opacity 0.2s, box-shadow 0.2s;
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
            box-shadow: 0 4px 12px rgba(8, 126, 164, 0.25);
        }

        .btn-coral {
            background-color: var(--coral);
            color: var(--white);
        }

        .btn-coral:hover {
            background-color: var(--coral-dark);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
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

        .btn-ghost {
            background-color: transparent;
            color: var(--navy);
            border: 1px solid transparent;
        }

        .btn-ghost:hover {
            background-color: var(--gray-light);
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

        .btn-large {
            padding: 0.875rem 1.75rem;
            font-size: 1.125rem;
        }

        /* Navbar */
        .navbar {
            background-color: var(--white);
            color: var(--navy);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 0.75rem 0;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--navy);
            flex-shrink: 0;
            position: relative;
            z-index: 1001;
        }

        .logo svg {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .navbar .logo {
            font-size: 1.75rem;
            margin: -0.5rem 0;
        }

        .navbar .logo svg {
            width: auto;
            height: 70px;
            filter: drop-shadow(0 4px 6px rgba(8, 126, 164, 0.2));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .logo-text span:first-child {
            color: var(--ocean);
        }

        .logo-text span:last-child {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--gray);
            letter-spacing: 0.05em;
        }

        .nav-search {
            flex: 1;
            max-width: 680px;
            position: relative;
            margin: 0 auto;
        }

        .nav-search input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 9999px;
            font-size: 0.95rem;
            background-color: var(--gray-light);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .nav-search input:focus {
            outline: none;
            border-color: var(--cyan);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(24, 174, 229, 0.12);
        }

        .nav-search svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.125rem;
            height: 1.125rem;
            color: var(--gray);
            pointer-events: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
            flex-shrink: 0;
            margin-left: auto;
        }

        .nav-links a {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--navy);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            border-radius: var(--radius);
            transition: color 0.2s, background-color 0.2s;
        }

        .nav-links a:hover,
        .nav-links button:hover {
            color: var(--ocean);
            background-color: var(--light-blue);
        }

        .nav-links button {
            background: none;
            border: none;
            font: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            border-radius: var(--radius);
            color: var(--navy);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .nav-link-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        .cart-link {
            position: relative;
        }

        .cart-badge {
            background-color: var(--coral);
            color: var(--white);
            font-size: 0.65rem;
            font-weight: 700;
            min-width: 1.1rem;
            height: 1.1rem;
            padding: 0 0.3rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--navy);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .navbar-inner {
                flex-wrap: wrap;
                padding: 0.625rem 0;
            }

            .navbar .logo {
                margin: -0.25rem 0;
            }

            .navbar .logo svg {
                width: auto;
                height: 54px;
            }

            .nav-search {
                order: 3;
                max-width: 100%;
                flex-basis: 100%;
                margin: 0;
            }

            .menu-toggle {
                display: block;
                margin-left: auto;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: var(--white);
                flex-direction: column;
                align-items: stretch;
                padding: 1rem clamp(1rem, 4vw, 3.75rem);
                gap: 0.25rem;
                box-shadow: var(--shadow);
                margin-left: 0;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a,
            .nav-links button {
                padding: 0.75rem 1rem;
                justify-content: flex-start;
                width: 100%;
            }
        }

        /* Main */
        main {
            min-height: calc(100vh - 200px);
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
            box-shadow: 0 0 0 3px rgba(8, 126, 164, 0.15);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Cards */
        .card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #f1f5f9;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .card-image-wrapper {
            position: relative;
            overflow: hidden;
        }

        .card-image {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            background-color: #e0f2fe;
            transition: transform 0.3s ease;
        }

        .card:hover .card-image {
            transform: scale(1.05);
        }

        .promo-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: var(--coral);
            color: var(--white);
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.35rem 0.65rem;
            border-radius: 9999px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-category {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ocean);
            margin-bottom: 0.375rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
            line-height: 1.35;
        }

        .card-price-block {
            margin-bottom: 0.625rem;
        }

        .card-price {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--navy);
        }

        .card-original-price {
            font-size: 0.8rem;
            color: var(--gray);
            text-decoration: line-through;
            margin-right: 0.5rem;
        }

        .card-discount {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--coral);
        }

        .card-meta {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .card-actions {
            margin-top: auto;
            padding-top: 0.75rem;
        }

        /* Seller identity block */
        .seller-block {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: var(--radius);
            padding: 0.625rem 0.75rem;
            margin-bottom: 0.625rem;
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .seller-avatar {
            flex-shrink: 0;
            width: 1.875rem;
            height: 1.875rem;
            background-color: var(--ocean);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .seller-avatar svg {
            width: 1rem;
            height: 1rem;
        }

        .seller-info {
            flex-grow: 1;
            min-width: 0;
        }

        .seller-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.25;
        }

        .seller-location {
            font-size: 0.7rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .seller-location-icon {
            width: 0.7rem;
            height: 0.7rem;
            flex-shrink: 0;
        }

        .seller-badge {
            flex-shrink: 0;
            font-size: 0.55rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 0.2rem 0.4rem;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .badge-local {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-umkm {
            background-color: #d1fae5;
            color: #065f46;
        }

        .card-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            margin-bottom: 0.75rem;
            font-size: 0.8rem;
        }

        .card-rating .stars {
            color: #f59e0b;
            letter-spacing: -0.05em;
        }

        .card-rating .rating-value {
            font-weight: 700;
            color: var(--navy);
        }

        /* Product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (min-width: 640px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
        }

        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
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

        /* Hero carousel */
        .hero-carousel {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 2rem;
            background-color: var(--navy);
            min-height: 420px;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            padding: clamp(1.5rem, 5vw, 4rem);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
        }

        .hero-slide-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .hero-slide-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(11, 31, 58, 0.92) 0%, rgba(11, 31, 58, 0.6) 60%, rgba(11, 31, 58, 0.2) 100%);
            z-index: 1;
        }

        .hero-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 120px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.08' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") repeat-x;
            background-size: 50% 100%;
            animation: waveMove 12s linear infinite;
            z-index: 1;
        }

        .hero-bubble {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.05));
            animation: bubbleFloat 6s ease-in-out infinite;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 600px;
        }

        .hero-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(4px);
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-title {
            font-size: clamp(1.75rem, 4vw, 3rem);
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-text {
            font-size: clamp(1rem, 1.5vw, 1.25rem);
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1.5rem;
            max-width: 500px;
        }

        .hero-cta {
            background-color: var(--cyan);
            color: var(--navy);
            font-weight: 700;
        }

        .hero-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(24, 174, 229, 0.35);
        }

        .hero-visual {
            position: absolute;
            right: clamp(1rem, 5vw, 4rem);
            top: 50%;
            transform: translateY(-50%);
            width: clamp(180px, 32vw, 420px);
            z-index: 2;
            display: none;
            animation: heroFloat 5s ease-in-out infinite;
        }

        .hero-visual img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.25));
            animation: slowZoom 8s ease-in-out infinite alternate;
        }

        @media (min-width: 768px) {
            .hero-visual {
                display: block;
            }
        }

        .hero-controls {
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 3;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            border: none;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .hero-dot.active {
            background-color: var(--cyan);
            transform: scale(1.3);
        }

        .hero-arrow {
            background-color: rgba(255, 255, 255, 0.12);
            color: var(--white);
            border: none;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 1rem;
        }

        .hero-arrow:hover {
            background-color: rgba(255, 255, 255, 0.25);
        }

        .hero-arrow.prev {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        .hero-arrow.next {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        @media (max-width: 767px) {
            .hero-arrow.prev,
            .hero-arrow.next {
                display: none;
            }
        }

        @keyframes waveMove {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        @keyframes bubbleFloat {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-20px) scale(1.1); opacity: 0.9; }
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(-50%) translateX(0); }
            50% { transform: translateY(-52%) translateX(5px); }
        }

        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.03); }
        }

        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .hero-slide.active .hero-badge { animation: fadeUp 0.6s ease forwards; }
        .hero-slide.active .hero-title { animation: fadeUp 0.6s ease 0.1s forwards; opacity: 0; }
        .hero-slide.active .hero-text { animation: fadeUp 0.6s ease 0.2s forwards; opacity: 0; }
        .hero-slide.active .hero-cta { animation: fadeUp 0.6s ease 0.3s forwards; opacity: 0; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Value proposition */
        .value-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .value-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .value-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #f1f5f9;
            transition: transform 0.2s;
        }

        .value-card:hover {
            transform: translateY(-4px);
        }

        .value-icon {
            width: 3.5rem;
            height: 3.5rem;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--seafoam) 0%, var(--light-blue) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ocean);
        }

        .value-icon svg {
            width: 1.75rem;
            height: 1.75rem;
        }

        .value-card h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .value-card p {
            font-size: 0.875rem;
            color: var(--gray);
            line-height: 1.5;
        }

        /* Promo section */
        .promo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .promo-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .promo-card {
            background: linear-gradient(135deg, var(--navy) 0%, var(--ocean) 100%);
            color: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s;
        }

        .promo-card:nth-child(2) {
            background: linear-gradient(135deg, var(--coral) 0%, #fb923c 100%);
        }

        .promo-card:nth-child(3) {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .promo-card:nth-child(4) {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        }

        .promo-card:hover {
            transform: translateY(-4px);
        }

        .promo-card h3 {
            font-size: 1.125rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .promo-card p {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .promo-card svg {
            position: absolute;
            right: -0.5rem;
            bottom: -0.5rem;
            width: 5rem;
            height: 5rem;
            opacity: 0.15;
        }

        /* Category chips */
        .category-scroll {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-chip {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.125rem;
            background-color: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--navy);
            transition: all 0.2s;
            cursor: pointer;
            white-space: nowrap;
        }

        .category-chip:hover,
        .category-chip.active {
            background-color: var(--ocean);
            color: var(--white);
            border-color: var(--ocean);
        }

        .category-chip svg {
            width: 1rem;
            height: 1rem;
        }

        /* Support local section */
        .support-section {
            background: linear-gradient(135deg, var(--navy) 0%, var(--ocean) 100%);
            color: var(--white);
            border-radius: var(--radius-lg);
            padding: clamp(2rem, 5vw, 4rem);
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .support-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        @media (min-width: 768px) {
            .support-section {
                grid-template-columns: 1fr 1fr;
            }
        }

        .support-content {
            position: relative;
            z-index: 1;
        }

        .support-content h2 {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .support-content p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            max-width: 500px;
        }

        .support-highlights {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .support-highlight {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: rgba(255, 255, 255, 0.12);
            padding: 0.5rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .support-visual {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .support-visual img {
            max-width: 100%;
            max-height: 320px;
            margin: 0 auto;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        /* Footer */
        .footer {
            background-color: var(--navy);
            color: var(--white);
            padding: 3rem 0 1.5rem;
            margin-top: 3rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: 2fr 1fr 1fr 1fr;
            }
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.75);
            margin-top: 0.75rem;
            max-width: 300px;
        }

        .footer h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.75);
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--cyan);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
        }

        /* Product detail page */
        .product-detail {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
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
            border-radius: var(--radius-lg);
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
            border-radius: var(--radius-lg);
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

        .free-shipping-bar {
            background-color: var(--gray-light);
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .free-shipping-progress {
            height: 8px;
            background-color: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
            margin: 0.5rem 0;
        }

        .free-shipping-progress > div {
            height: 100%;
            background: linear-gradient(90deg, var(--success), var(--cyan));
            transition: width 0.4s ease;
        }

        .free-shipping-text {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .free-shipping-text strong {
            color: var(--navy);
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
            border-radius: var(--radius-lg);
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
            max-width: 700px;
            margin: 2rem auto;
            background-color: var(--white);
            padding: 2rem;
            border-radius: var(--radius-lg);
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

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(11, 31, 58, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            padding: 1rem;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: var(--shadow-lg);
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gray-light);
            border: none;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.25rem;
            color: var(--navy);
            z-index: 10;
        }

        .modal-close:hover {
            background-color: #e2e8f0;
        }

        .modal-body {
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .modal-body {
                grid-template-columns: 1fr 1fr;
            }
        }

        .modal-image {
            width: 100%;
            height: 100%;
            min-height: 300px;
            object-fit: cover;
            background-color: #e0f2fe;
        }

        .modal-content {
            padding: 2rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .modal-price-block {
            margin: 1rem 0;
        }

        .modal-original-price {
            font-size: 0.95rem;
            color: var(--gray);
            text-decoration: line-through;
            margin-right: 0.5rem;
        }

        .modal-price {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--navy);
        }

        .modal-discount {
            display: inline-block;
            background-color: var(--coral);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            margin-left: 0.5rem;
        }

        .variant-options {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 0.75rem 0 1rem;
        }

        .variant-option {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: var(--radius);
            background-color: var(--white);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .variant-option:hover {
            border-color: var(--cyan);
        }

        .variant-option.active {
            border-color: var(--ocean);
            background-color: var(--light-blue);
            color: var(--ocean);
        }

        .quantity-selector {
            display: inline-flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: var(--radius);
            overflow: hidden;
        }

        .quantity-selector button {
            width: 2.25rem;
            height: 2.25rem;
            border: none;
            background-color: var(--gray-light);
            cursor: pointer;
            font-size: 1rem;
            color: var(--navy);
        }

        .quantity-selector button:hover {
            background-color: #e2e8f0;
        }

        .quantity-selector input {
            width: 3rem;
            height: 2.25rem;
            border: none;
            text-align: center;
            font-weight: 700;
        }

        .subtotal-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 1rem;
            font-size: 1.125rem;
        }

        .subtotal-row strong {
            font-size: 1.25rem;
            color: var(--navy);
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .modal-actions .btn {
            flex: 1;
        }

        @media (max-width: 767px) {
            .modal {
                max-height: 95vh;
            }
        }

        /* Section header with link */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .section-header a {
            color: var(--ocean);
            font-weight: 700;
            font-size: 0.95rem;
        }

        .section-header a:hover {
            color: var(--ocean-dark);
        }
    </style>
    @stack('styles')
</head>
<body>
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
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo" style="color: white;">
                        <svg viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M10 32 Q25 24 40 32 Q55 40 70 32" stroke="#18AEE5" stroke-width="3" stroke-linecap="round" fill="none"/>
                            <ellipse cx="32" cy="18" rx="14" ry="9" fill="#087EA4"/>
                            <path d="M18 18 L6 10 L6 26 Z" fill="#087EA4"/>
                            <circle cx="40" cy="15" r="2.5" fill="white"/>
                            <circle cx="41" cy="15" r="1.2" fill="#0B1F3A"/>
                            <text x="54" y="26" font-family="Segoe UI, sans-serif" font-size="18" font-weight="800" fill="white">U-Sea</text>
                        </svg>
                    </a>
                    <p>From the Sea, Direct to You. Belanja dari laut dan bantu nelayan lokal Indonesia.</p>
                </div>

                <div>
                    <h4>About</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="#support-local">Support Local</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Help</h4>
                    <ul class="footer-links">
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Support</h4>
                    <ul class="footer-links">
                        <li><a href="#">Local Fishermen</a></li>
                        <li><a href="#">UMKM Pesisir</a></li>
                        <li><a href="#">Fresh Seafood</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; {{ date('Y') }} U-Sea. From the Sea, Direct to You.
            </div>
        </div>
    </footer>

    <!-- Product Modal -->
    <div class="modal-overlay" id="productModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal">
            <button type="button" class="modal-close" onclick="closeProductModal()" aria-label="Close modal">&times;</button>
            <div class="modal-body">
                <img id="modalImage" src="" alt="" class="modal-image">
                <div class="modal-content">
                    <div class="card-category" id="modalCategory"></div>
                    <h2 class="modal-title" id="modalTitle"></h2>

                    <div class="seller-block" style="margin-top: 0.5rem;">
                        <div class="seller-avatar" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="seller-info">
                            <div class="seller-name" id="modalSeller"></div>
                            <div class="seller-location">
                                <svg class="seller-location-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                </svg>
                                <span id="modalLocation"></span>
                            </div>
                        </div>
                    </div>

                    <p id="modalDescription" style="color: var(--gray); font-size: 0.9rem; margin: 0.75rem 0;"></p>

                    <div class="card-rating" id="modalRating"></div>

                    <div style="margin-bottom: 0.5rem; font-weight: 700; font-size: 0.9rem;">Choose Weight</div>
                    <div class="variant-options" id="modalVariants"></div>

                    <div style="margin: 1rem 0 0.5rem; font-weight: 700; font-size: 0.9rem;">Quantity</div>
                    <div class="quantity-selector">
                        <button type="button" onclick="adjustModalQty(-1)">-</button>
                        <input type="number" id="modalQty" value="1" min="1" readonly>
                        <button type="button" onclick="adjustModalQty(1)">+</button>
                    </div>

                    <div class="modal-price-block">
                        <span class="modal-original-price" id="modalOriginalPrice"></span>
                        <span class="modal-price" id="modalPrice"></span>
                        <span class="modal-discount" id="modalDiscount"></span>
                    </div>

                    <div class="subtotal-row">
                        <span>Subtotal</span>
                        <strong id="modalSubtotal">Rp 0</strong>
                    </div>

                    <form id="modalAddForm" method="POST">
                        @csrf
                        <input type="hidden" name="variant_id" id="modalVariantId" value="">
                        <input type="hidden" name="quantity" id="modalFormQty" value="1">
                        <input type="hidden" name="redirect" id="modalRedirect" value="">
                        <div class="modal-actions">
                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('modalRedirect').value=''">Add to Cart</button>
                            <button type="submit" class="btn btn-coral" onclick="document.getElementById('modalRedirect').value='checkout'">Buy Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile nav close on link click
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.nav-links').classList.remove('active');
            });
        });

        // Product Modal
        const productModal = document.getElementById('productModal');
        let currentVariants = [];
        let selectedVariant = null;
        let currentProduct = {};

        document.querySelectorAll('.open-product-modal').forEach(btn => {
            btn.addEventListener('click', () => openProductModal(btn.dataset));
        });

        function openProductModal(data) {
            currentProduct = data;
            currentVariants = JSON.parse(data.variants || '[]');

            document.getElementById('modalImage').src = data.productImage;
            document.getElementById('modalImage').alt = data.productName;
            document.getElementById('modalCategory').textContent = data.productCategory;
            document.getElementById('modalTitle').textContent = data.productName;
            document.getElementById('modalSeller').textContent = data.productSeller;
            document.getElementById('modalLocation').textContent = data.productLocation;
            document.getElementById('modalDescription').textContent = data.productDescription;
            document.getElementById('modalAddForm').action = data.addUrl;

            const rating = parseFloat(data.productRating) || 4.8;
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= Math.round(rating) ? '★' : '☆';
            }
            document.getElementById('modalRating').innerHTML = `<span class="stars">${starsHtml}</span><span class="rating-value">${rating.toFixed(1)}</span>`;

            renderVariants(data);
            document.getElementById('modalQty').value = 1;
            updateModalPrice();

            productModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function renderVariants(data) {
            const container = document.getElementById('modalVariants');
            container.innerHTML = '';

            if (currentVariants.length === 0) {
                selectedVariant = null;
                return;
            }

            currentVariants.forEach((variant, index) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'variant-option' + (index === 0 ? ' active' : '');
                btn.textContent = variant.weight;
                btn.dataset.id = variant.id;
                btn.dataset.price = variant.price;
                btn.dataset.originalPrice = variant.original_price || '';
                btn.dataset.discount = variant.discount_percentage || '';
                btn.dataset.stock = variant.stock;
                btn.addEventListener('click', () => selectVariant(btn, variant));
                container.appendChild(btn);
            });

            selectedVariant = currentVariants[0];
            document.getElementById('modalVariantId').value = selectedVariant.id;
        }

        function selectVariant(btn, variant) {
            document.querySelectorAll('.variant-option').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedVariant = variant;
            document.getElementById('modalVariantId').value = variant.id;
            updateModalPrice();
        }

        function adjustModalQty(delta) {
            const input = document.getElementById('modalQty');
            let value = parseInt(input.value) + delta;
            const stock = selectedVariant ? selectedVariant.stock : parseInt(currentProduct.productStock || 999);
            if (value < 1) value = 1;
            if (value > stock) value = stock;
            input.value = value;
            document.getElementById('modalFormQty').value = value;
            updateModalPrice();
        }

        function updateModalPrice() {
            const qty = parseInt(document.getElementById('modalQty').value) || 1;
            const price = selectedVariant ? selectedVariant.price : parseInt(currentProduct.productPrice || 0);
            const originalPrice = selectedVariant ? (selectedVariant.original_price || 0) : parseInt(currentProduct.productOriginalPrice || 0);
            const discount = selectedVariant ? (selectedVariant.discount_percentage || 0) : parseInt(currentProduct.productDiscount || 0);

            document.getElementById('modalPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
            document.getElementById('modalOriginalPrice').textContent = originalPrice > price ? 'Rp ' + originalPrice.toLocaleString('id-ID') : '';
            document.getElementById('modalDiscount').textContent = discount > 0 ? '-' + discount + '%' : '';
            document.getElementById('modalSubtotal').textContent = 'Rp ' + (price * qty).toLocaleString('id-ID');
            document.getElementById('modalFormQty').value = qty;
        }

        function closeProductModal() {
            productModal.classList.remove('active');
            document.body.style.overflow = '';
        }

        productModal.addEventListener('click', (e) => {
            if (e.target === productModal) closeProductModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && productModal.classList.contains('active')) {
                closeProductModal();
            }
        });

        // Hero Carousel
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.hero-dot');
        let currentSlide = 0;
        let slideInterval;
        const slideDelay = 4500;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            showSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        function startCarousel() {
            slideInterval = setInterval(nextSlide, slideDelay);
        }

        function resetCarousel() {
            clearInterval(slideInterval);
            startCarousel();
        }

        if (slides.length > 0) {
            startCarousel();

            const carousel = document.querySelector('.hero-carousel');
            if (carousel) {
                carousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
                carousel.addEventListener('mouseleave', startCarousel);
            }
        }

        // Expose carousel controls globally
        window.nextSlide = nextSlide;
        window.prevSlide = prevSlide;
        window.showSlide = showSlide;
        window.resetCarousel = resetCarousel;
    </script>

    @stack('scripts')
</body>
</html>
