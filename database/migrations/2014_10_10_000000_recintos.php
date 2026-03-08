<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recintos', function (Blueprint $table) {
            $table->bigIncrements('reci_id');
            $table->string('reci_nombre', 100);
            $table->text('reci_descripcion')->nullable();
            $table->boolean('reci_activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recintos');
    }
};
