<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_number',
        'machine_type',
        'machine_status',
    ];

    // Definición de la relación con AssignedTask
    public function assignedTasks()
    {
        return $this->hasMany(AssignedTask::class);
    }
}
