<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignedTask;

class HistorialController extends Controller
{
    /**
     * Muestra el historial de tareas.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $tasks = AssignedTask::whereIn('status_task', ['Completada', 'Incompleta'])
                                 ->orderBy('updated_at', 'desc')
                                 ->get();
            return view('Historial', ['tasks' => $tasks, 'user' => $user]);
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Elimina una tarea.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $task = AssignedTask::findOrFail($id);
            $task->delete();
            return redirect()->route('historial')->with('success', 'Tarea eliminada exitosamente.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
