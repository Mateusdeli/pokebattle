<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        DB::commit();

        if (!empty($user)) {
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('verification.notice');
        } else {
            return back()->withErrors([
                'Erro ao tentar se cadastrar!'
            ]);
        }
    }
}
