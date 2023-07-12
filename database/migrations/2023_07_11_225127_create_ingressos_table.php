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
        Schema::create('ingressos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evento_id");
            $table->string("lote");
            $table->date("inicio")->nullable();
            $table->date("fim")->nullable();
            $table->integer("quantidade_disponivel")->nullable();
            $table->double("preco");
            $table->timestamps();

            $table->foreign("evento_id")->references("id")->on("eventos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingressos');
    }
};
