<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AssignedTask; // Asegúrate de importar tu modelo

class UpdateTaskStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of tasks that are overdue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = now(); // Obtén la fecha actual

        // Encuentra todas las tareas cuya fecha límite ha pasado y su estado no es "Completada"
        $tasks = AssignedTask::where('due_date', '>', $today)
                             ->where('status_task', '<>', 'Completada')
                             ->update(['status_task' => 'Incompleta']);

        // Obtén el número de tareas actualizadas
        $updatedTasksCount = AssignedTask::where('due_date', '>', $today)
                                         ->where('status_task', 'Incompleta')
                                         ->count();

        // Muestra el mensaje de éxito con el conteo de tareas actualizadas
        $this->info("Tareas actualizadas con éxito. Número de tareas marcadas como 'Incompleta': $updatedTasksCount");

        return 0;
    }
}
