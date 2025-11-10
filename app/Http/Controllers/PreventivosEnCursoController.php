<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignedTask;
use App\Models\User;

class PreventivosEnCursoController extends Controller
{
    /**
     * Muestra las tareas en curso.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtén el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Actualiza el estado de las tareas según la fecha de vencimiento
            $this->updateTaskStatuses();

            // Obtén las tareas con los estados deseados
            $tasks = AssignedTask::whereIn('status_task', ['Asignada', 'En Progreso'])->get();
            // Obtén solo los usuarios con rol 'usuario'
            $users = User::where('role', 'usuario')->get();

            return view('PreventivosEncurso', ['tasks' => $tasks, 'users' => $users, 'user' => $user]);
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

    /**
     * Actualiza una tarea asignada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user(); // Obtén el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $task = AssignedTask::find($id);

            if ($task) {
                // Valida la solicitud
                $request->validate([
                    'user_id' => 'required|exists:users,id,role,usuario', // Asegúrate de que el user_id exista en la tabla users y tenga el rol correcto
                ]);

                // Actualiza el usuario asignado
                $task->user_id = $request->input('user_id');
                $task->save();

                return redirect()->route('preventivos-en-curso')->with('success', 'Usuario asignado actualizado correctamente.');
            } else {
                return redirect()->route('preventivos-en-curso')->with('error', 'Tarea no encontrada.');
            }
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Elimina una tarea asignada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user(); // Obtén el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $task = AssignedTask::find($id);

            if ($task) {
                $task->delete();
                return redirect()->route('preventivos-en-curso')->with('success', 'Tarea eliminada exitosamente.');
            } else {
                return redirect()->route('preventivos-en-curso')->with('error', 'Tarea no encontrada.');
            }
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
