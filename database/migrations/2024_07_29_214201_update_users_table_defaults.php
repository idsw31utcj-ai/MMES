<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableDefaults extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('usuario')->change();
            $table->string('status')->default('activo')->change();
            $table->string('position')->default('Técnico de mantenimiento')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
            $table->string('status')->change();
            $table->string('position')->change();
        });
    }
}
