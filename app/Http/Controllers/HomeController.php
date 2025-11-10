<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AssignedTask;

class HomeController extends Controller
{
    /**
     * Muestra la vista de inicio.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Actualiza el estado de las tareas basado en la fecha límite
            $this->updateTaskStatuses();

            return view('inicio', [
                'user' => $user,
            ]);
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Muestra el historial.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showHistorial()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            return view('historial', ['user' => $user]);
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Actualiza el estado de las tareas basado en la fecha límite.
     *
     * @return void
     */
    protected function updateTaskStatuses()
    {
        // Actualiza el estado de las tareas si la fecha de vencimiento ya ha pasado
        AssignedTask::whereIn('status_task', ['Asignada', 'En Progreso'])
            ->where('due_date', '<', now())
            ->update(['status_task' => 'Incompleta']);
    }
}
