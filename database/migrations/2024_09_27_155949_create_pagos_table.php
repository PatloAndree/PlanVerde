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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes')->onDelete('cascade');
            $table->string('plan_nombre');
            $table->text('plan_descripcion');
            $table->enum('tipo_pago', ['mensual', 'anual'])->default('mensual');
            $table->decimal('monto', 11, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->datetime('fecha_pago')->nullable();
            $table->integer('status')->default(2); // Pendiente por defecto ||2 pendiente || 1 pagado |
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
