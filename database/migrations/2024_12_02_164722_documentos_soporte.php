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
        //     //
        Schema::create('documentos_soportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('respuesta_tickets_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->text('ruta');
            $table->string('extension');
            $table->integer('tipo');
            $table->string('file_id')->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_soportes');

    }
};
