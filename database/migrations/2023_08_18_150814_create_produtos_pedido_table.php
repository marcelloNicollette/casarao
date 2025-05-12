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
        Schema::create('produtos_pedido', function (Blueprint $table) {
            $table->id();
            $table->integer('pedido_id');
            $table->integer('cod_produto');
            $table->string('produto');
            $table->string('qtd_status')->default('S');
            $table->string('tipo_caixa')->nullable();
            $table->integer('qtd');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_pedido');
    }
};
