<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAuthController extends Controller
{
    // POST /login
    public function login(Request $request)
    {
        $data = $request->validate([
            'user_id'  => 'required|string',
            'password' => 'required|string',
        ]);

        // Auth against staff provider using username column
        if (Auth::attempt(['username' => $data['user_id'], 'password' => $data['password']], false)) {
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['user_id' => 'Invalid credentials.'])->onlyInput('user_id');
    }

    // GET /dashboard (behind auth middleware)
    public function dashboard()
    {
        $user = Auth::user(); // <- use the guard, not manual session
        if ($user && $user->username === 'receptionist12plk') {
            return view('customerForm');
        }
        return view('loanofficerdashboard');
    }

    // POST /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'you logged out!');
    }
}
?>