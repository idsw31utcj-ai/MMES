<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedTasksTable extends Migration
{
    public function up()
    {
        Schema::create('assigned_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('checklist');
            $table->date('due_date');
            $table->enum('status_task', ['Asignada', 'En Progreso', 'Completada', 'Incompleta'])->default('Asignada');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assigned_tasks');
    }
}
