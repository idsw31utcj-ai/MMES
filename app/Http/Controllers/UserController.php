<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $users = User::all(); // Obtiene todos los usuarios
            return view('Usuarios', compact('users', 'user')); // Pasa los datos a la vista
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Muestra el formulario de creación de usuario.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            return view('usuarios');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Almacena un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Validar la entrada
            $request->validate([
                'username' => 'required|unique:users,username',
                'password' => 'required|min:8',
                'clock_number' => 'required|unique:users,clock_number',
            ]);

            // Crear un nuevo usuario con valores predeterminados
            User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'clock_number' => $request->clock_number,
                'role' => 'usuario', // Valor predeterminado
                'status' => 'activo', // Valor predeterminado
                'position' => 'Técnico de mantenimiento', // Valor predeterminado
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado con éxito.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Elimina un usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Actualiza el estado del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'status' => 'required|in:activo,inactivo',
            ]);

            $user = User::findOrFail($request->user_id);
            $user->status = $request->status;
            $user->save();

            return redirect()->route('usuarios.index')->with('success', 'Estado del usuario actualizado con éxito.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
