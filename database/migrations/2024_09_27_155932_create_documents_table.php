<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Documents;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->unsignedInteger('min_size');
            $table->unsignedInteger('max_size');
            $table->boolean('alphanumeric')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Documents::create([
            'name' => 'Documento nacional de identidad',
            'short_name' => 'DNI',
            'min_size' => '8',
            'max_size' => '8',
            'alphanumeric' => 0,
            'status' => 1
        ]);
        Documents::create([
            'name' => 'Registro Único de Contribuyentes',
            'short_name' => 'RUC',
            'min_size' => '11',
            'max_size' => '11',
            'alphanumeric' => 0,
            'status' => 1
        ]);
        Documents::create([
            'name' => 'Carnet de extranjeria',
            'short_name' => 'CARNET EXT.',
            'min_size' => '10',
            'max_size' => '12',
            'alphanumeric' => 1,
            'status' => 1
        ]);
        Documents::create([
            'name' => 'Pasaporte',
            'short_name' => 'PASAPORTE',
            'min_size' => '10',
            'max_size' => '12',
            'alphanumeric' => 1,
            'status' => 1
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
