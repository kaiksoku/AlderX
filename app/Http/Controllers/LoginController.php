<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user(); // Obtén el usuario autenticado
            return redirect()->intended('home')->with('mensaje', 'Bienvenido, ' . $user->name . ', ¡Ha iniciado sesión con éxito!.');
        }
        

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }
}

