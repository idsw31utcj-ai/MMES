<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        return view('index'); // Nombre de la vista para el formulario de inicio de sesión
    }

    /**
     * Maneja el inicio de sesión de usuarios.
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        // Obtener las credenciales del formulario
        $credentials = $request->only('username', 'password');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificar el estado del usuario
            if ($user->status !== 'activo') {
                // Cerrar sesión si el usuario no está activo
                Auth::logout();
                return redirect('/')
                    ->withErrors(['username' => 'El usuario no existe o no está activo.']);
            }

            // Redirigir según el rol del usuario
            if ($user->role === 'usuario') {
                return redirect('/welcome'); // Redirección correcta para usuarios
            }

            return redirect('/inicio'); // Redirección para otros roles
        }

        return redirect('/')
            ->withErrors([
                'username' => 'Las credenciales proporcionadas no son correctas.',
            ]);
    }

    /**
     * Maneja el cierre de sesión de usuarios.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
