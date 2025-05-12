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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('email')->unique();
            $table->string('cnpj')->unique();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('colaborador_id')->constrained('colaboradores');
            $table->integer('price_tables_id');
            $table->timestamps();
            $table->softDeletes(); // Add this line for SoftDelete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
