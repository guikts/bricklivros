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
       Schema::create('emprestimos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // Vincula ao leitor/usuário[cite: 1]
        $table->foreignId('livro_id')->constrained('livros'); // Vincula ao livro[cite: 1]
        $table->date('data_emprestimo');
        $table->date('data_limite_devolucao'); // Prazo limite[cite: 1]
        $table->date('data_devolucao')->nullable(); // Registro de saída[cite: 1]
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
