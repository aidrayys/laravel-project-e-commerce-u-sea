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
