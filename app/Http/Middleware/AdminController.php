<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra la página de inicio para administradores.
     */
    public function index()
    {
        return view('admin.inicio'); // Asegúrate de tener una vista llamada 'admin/inicio.blade.php'
    }
}
