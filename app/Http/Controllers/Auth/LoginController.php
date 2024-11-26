<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Usuario no encontrado');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Contraseña incorrecta');
        }

        // Iniciar la sesión del usuario
        Auth::login($user);

        // Redirigir según el rol del usuario o a la página principal
        return redirect()->route('index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
