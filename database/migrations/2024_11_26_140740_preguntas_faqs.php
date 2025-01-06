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
        //
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta');
            $table->text('respuesta')->nullable();
            $table->integer('status')->default(1); // Campo de estado
            $table->timestamps(); // Utiliza el timestamp por defecto
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('faqs');

    }
};
