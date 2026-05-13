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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nome do leitor[cite: 1]
        $table->string('cpf_matricula')->unique()->nullable(); // CPF ou matrícula[cite: 1]
        $table->string('email')->unique(); // E-mail[cite: 1]
        $table->string('telefone')->nullable(); // Telefone[cite: 1]
        $table->enum('status', ['ativo', 'em_atraso', 'bloqueado'])->default('ativo'); // Controle de status[cite: 1]
        $table->string('password'); // Senha para o login
        $table->enum('role', ['cliente', 'bibliotecario'])->default('cliente'); // Nível de acesso
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
