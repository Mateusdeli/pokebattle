<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {

        $login = $request->only('email', 'password');

        if (Auth::attempt($login)) {
            $request->session()->regenerate();
            return redirect()->route('painel.index');
        }

        return back()->withErrors([
            'Login inválido!'
        ]);
    }
}
