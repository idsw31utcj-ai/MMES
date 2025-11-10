<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask;

class TaskController extends Controller
{
    /**
     * Muestra los detalles de una tarea específica.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $task = AssignedTask::find($id);
        $user = auth()->user();

        if (!$task) {
            return redirect()->route('welcome')->withErrors(['message' => 'Tarea no encontrada.']);
        }

        // Verifica si el usuario tiene el rol 'usuario'
        if ($user && $user->role === 'usuario') {
            // Actualiza el estado de la tarea a "En Progreso" al acceder a la vista
            $task->status_task = 'En Progreso';
            $task->updated_at = now(); // Establece la fecha y hora actuales
            $task->save();

            return view('task', ['task' => $task]);
        }

        // Redirige al inicio de sesión si el rol no es 'usuario'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Marca la tarea como completada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request, $id)
    {
        $task = AssignedTask::find($id);
        $user = auth()->user();

        if (!$task) {
            return redirect()->route('welcome')->withErrors(['message' => 'Tarea no encontrada.']);
        }

        // Verifica si el usuario tiene el rol 'usuario'
        if ($user && $user->role === 'usuario') {
            // Actualizar el estado de la tarea y establecer la fecha y hora actuales
            $task->status_task = 'Completada';
            $task->updated_at = now(); // La zona horaria está configurada en config/app.php
            $task->save();

            return redirect()->route('welcome')->with('message', 'Tarea completada con éxito.');
        }

        // Redirige al inicio de sesión si el rol no es 'usuario'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
