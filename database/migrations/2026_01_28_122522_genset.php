<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genset', function (Blueprint $table) {
            $table->id('gen_id');

            $table->string('gen_numero')->unique();
            $table->integer('gen_medida')->nullable();
            $table->decimal('gen_consumo', 2, 1)->nullable();
            $table->enum('gen_estado', ['disponible', 'taller'])
                  ->default('disponible');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genset');
    }
};
