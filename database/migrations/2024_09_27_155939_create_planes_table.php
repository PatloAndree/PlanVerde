<?php

use App\Models\Planes;
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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio_mensual', 11, 2);
            $table->decimal('precio_anual', 11, 2);
            $table->timestamps();
            $table->integer('status')->default(1);
        });

        Planes::create([
            'nombre' => 'Small',
            'descripcion' => '-',
            'precio_mensual' => '99.00',
            'precio_anual' => '950.00',
            'status' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
