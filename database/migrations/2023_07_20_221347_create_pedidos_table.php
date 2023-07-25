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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->double("valor_total");
            $table->string("status");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
        });

        Schema::create('pedido_ingresso', function (Blueprint $table) {
            $table->unsignedBigInteger("pedido_id");
            $table->unsignedBigInteger("ingresso_id");
            $table->integer("quantidade")->nullable()->default(1);

            $table->foreign("pedido_id")->references("id")->on("pedidos");
            $table->foreign("ingresso_id")->references("id")->on("ingressos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_ingresso');
        Schema::dropIfExists('pedidos');
    }
};
