<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Machine;

class MachineController extends Controller
{
    /**
     * Muestra la vista con el formulario y el listado de máquinas.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $machines = Machine::all(); // Obtén todas las máquinas
            return view('adminmaquinas', ['machines' => $machines, 'currentUser' => $user]);
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Almacena una nueva máquina en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            // Validar los datos del formulario
            $request->validate([
                'machine_number' => 'required|string|max:255|unique:machines',
                'machine_type' => 'required|string',
                'machine_status' => 'required|string|in:activo,inactivo',
            ], [
                'machine_number.unique' => 'El número de máquina ya ha sido utilizado.',
            ]);

            // Crear una nueva máquina
            Machine::create([
                'machine_number' => $request->machine_number,
                'machine_type' => $request->machine_type,
                'machine_status' => $request->machine_status,
            ]);

            // Redirigir con un mensaje de éxito
            return redirect()->route('adminmaquinas.index')->with('success', 'Máquina agregada exitosamente.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Elimina una máquina de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $machine = Machine::findOrFail($id);
            $machine->delete();

            // Redirigir con un mensaje de éxito
            return redirect()->route('adminmaquinas.index')->with('success', 'Máquina eliminada exitosamente.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }

    /**
     * Actualiza el estado de una máquina.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verifica si el usuario tiene el rol 'admin'
        if ($user && $user->role === 'admin') {
            $request->validate([
                'machine_id' => 'required|exists:machines,id',
                'machine_status' => 'required|string|in:activo,inactivo',
            ]);

            $machine = Machine::findOrFail($request->machine_id);
            $machine->machine_status = $request->machine_status;
            $machine->save();

            return redirect()->route('adminmaquinas.index')->with('success', 'Estado de la máquina actualizado exitosamente.');
        }

        // Redirige al inicio de sesión si el rol no es 'admin'
        return redirect('/')->withErrors(['message' => 'Acceso no autorizado.']);
    }
}
