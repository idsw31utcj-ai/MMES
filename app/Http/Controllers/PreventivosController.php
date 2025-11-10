<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PreventivosController extends Controller
{
    /**
     * Muestra la vista de preventivos.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            return view('Preventivos', ['user' => $user]);
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
