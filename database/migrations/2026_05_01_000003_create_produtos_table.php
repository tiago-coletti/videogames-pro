<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->integer('estoque')->default(0);
            $table->string('imagem')->nullable();
            $table->string('tipo')->default('jogo'); // jogo | console | acessorio
            $table->string('classificacao_etaria')->nullable(); // Livre, 10, 12, 14, 16, 18
            $table->string('desenvolvedora')->nullable();
            $table->string('distribuidora')->nullable();
            $table->date('data_lancamento')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('ativo')->default(true);
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('plataforma_id')->nullable()->constrained('plataformas')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
