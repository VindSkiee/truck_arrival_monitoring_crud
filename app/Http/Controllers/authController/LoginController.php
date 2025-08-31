<?php

namespace App\Http\Controllers\authController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showRoleSelection()
    {
        return view('auth.select-role');
    }

    public function loginForm($role)
    {
        return view('auth.login', compact('role'));
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'cs') {
                return redirect()->route('cs.dashboard');
            } elseif ($user->role === 'security') {
                return redirect()->route('security.dashboard');
            } elseif ($user->role === 'warehouse') {
                return redirect()->route('warehouse.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logoutUser(Request $request)
    {
        Auth::logout(); // keluarin user

        // invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('select.role')->with('success', 'Berhasil logout.');

    }
}
