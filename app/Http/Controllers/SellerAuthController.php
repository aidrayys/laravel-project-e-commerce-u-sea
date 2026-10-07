<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($credentials['username'] === 'pesisirrasa' && $credentials['password'] === '123') {
            session(['seller_logged_in' => true, 'seller_name' => 'Pesisir Rasa', 'seller_location' => 'Lamongan']);

            return redirect()->route('seller.dashboard');
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function logout(): RedirectResponse
    {
        session()->forget(['seller_logged_in', 'seller_name', 'seller_location']);

        return redirect()->route('home');
    }
}
