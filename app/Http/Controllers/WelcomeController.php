<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verifica si el usuario tiene el rol 'usuario'
        if ($user && $user->role === 'usuario') {
            // Actualiza el estado de las tareas según la fecha límite
            $currentDate = Carbon::now();

            AssignedTask::where('user_id', $user->id)
                        ->whereIn('status_task', ['Asignada', 'En Progreso'])
                        ->where('due_date', '<', $currentDate)
                        ->update(['status_task' => 'Incompleta']);

            // Obtén las tareas del usuario con los estados deseados
            $tasks = AssignedTask::where('user_id', $user->id)
                                 ->whereIn('status_task', ['Asignada', 'En Progreso'])
                                 ->get();

            return view('welcome', ['user' => $user, 'tasks' => $tasks]);
        }

        // Redirige al inicio de sesión si el rol no es 'usuario'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}

