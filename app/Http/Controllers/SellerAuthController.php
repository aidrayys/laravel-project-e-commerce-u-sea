<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SellerAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session('seller_logged_in')) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.login');
    }

    /**
     * Login penjual. Kredensial dibaca dari config/seller.php (.env),
     * password diverifikasi dengan Hash::check (bcrypt), dan session ID
     * di-regenerate untuk mencegah session fixation.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = config('seller.username');
        $passwordHash = config('seller.password_hash');

        $valid = $username && $passwordHash
            && hash_equals((string) $username, $credentials['username'])
            && Hash::check($credentials['password'], $passwordHash);

        if (! $valid) {
            return redirect()->back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        $request->session()->regenerate();
        session([
            'seller_logged_in' => true,
            'seller_name' => config('seller.name'),
            'seller_location' => config('seller.location'),
        ]);

        return redirect()->route('seller.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        session()->forget(['seller_logged_in', 'seller_name', 'seller_location']);
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
