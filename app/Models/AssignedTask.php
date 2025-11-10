<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'user_id',
        'checklist',
        'due_date',
        'status_task',
    ];

    protected $casts = [
        'checklist' => 'array',
        'due_date' => 'datetime',
    ];

    // Definición de la relación con Machine
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    // Definición de la relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
