<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\User;
use App\Models\AssignedTask;
use Illuminate\Support\Facades\Auth;

class AsignacionController extends Controller
{
    /**
     * Muestra la vista de asignación de tareas.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Obtén las máquinas activas y los usuarios activos
            $machines = Machine::where('machine_status', 'activo')->get();
            $users = User::where('status', 'activo')->where('role', 'usuario')->get();

            return view('Asignacion', compact('machines', 'users', 'user'));
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Almacena una nueva tarea asignada.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Valida la solicitud
            $request->validate([
                'machine_id' => 'required|exists:machines,id',
                'user_id' => 'required|exists:users,id',
                'checklist' => 'required|array',
                'due_date' => 'required|date',
            ]);

            $machineId = $request->input('machine_id');
            $userId = $request->input('user_id');
            $checklist = $request->input('checklist');
            $dueDate = $request->input('due_date');

            // Verifica si ya existe una tarea asignada o en progreso para la misma máquina
            $existingTaskForMachine = AssignedTask::where('machine_id', $machineId)
                ->whereIn('status_task', ['Asignada', 'En Progreso'])
                ->exists();

            $existingTaskForUser = AssignedTask::where('user_id', $userId)
                ->where('machine_id', $machineId)
                ->whereIn('status_task', ['Asignada', 'En Progreso'])
                ->exists();

            if ($existingTaskForMachine || $existingTaskForUser) {
                // Redirige con un error si ya existe una tarea en la máquina seleccionada
                return redirect()->back()->withErrors(['message' => 'No se puede asignar la tarea. Ya existe una tarea asignada o en progreso para esta máquina o usuario.'])->withInput();
            }

            // Crea la tarea asignada
            AssignedTask::create([
                'machine_id' => $machineId,
                'user_id' => $userId,
                'checklist' => json_encode($checklist),
                'due_date' => $dueDate,
                'status_task' => 'Asignada', // Asegúrate de definir el estado inicial
            ]);

            // Obtén el usuario y la máquina seleccionados para mostrar el mensaje
            $user = User::find($userId);
            $machine = Machine::find($machineId);

            // Redirige con el mensaje
            return redirect()->back()->with('success', "Tarea asignada al usuario {$user->username} en la máquina {$machine->machine_number}");
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
