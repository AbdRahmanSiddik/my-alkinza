<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        try {
            $toko = new TokoController();
            $toko->setSessionToko();
        } catch (\Throwable $th) {
            return redirect()->route('toko.index')->with('error', 'Gagal mendapatkan data toko. Silakan tambahkan Toko anda.');
        }

        // 🔥 Tambahan: Cek role kasir
        if (auth()->user()->hasRole('kasir')) {
            return redirect()->route('kasir');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        FacadesSession::forget('toko');

        return redirect('/');
    }
}
