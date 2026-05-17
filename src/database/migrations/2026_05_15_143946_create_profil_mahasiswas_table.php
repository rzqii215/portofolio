<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_mahasiswas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nim')->unique();
            $table->string('nomor_hp')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('angkatan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();

            $table->index(['program_studi', 'angkatan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_mahasiswas');
    }
};