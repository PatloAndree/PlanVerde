<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('encuesta_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('encuesta_id')->constrained()->onDelete('cascade');
            $table->text('encuesta_preguntas');
            $table->text('encuesta_respuestas')->nullable();
            $table->integer('notificado')->default(0);
            $table->integer('status')->default(2); //pendiente
            $table->timestamps();//
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_clientes');
    }
};
