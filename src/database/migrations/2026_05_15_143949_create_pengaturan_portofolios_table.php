<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_portofolios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profil_mahasiswa_id')
                ->constrained('profil_mahasiswas')
                ->cascadeOnDelete();

            $table->boolean('public')->default(false);
            $table->string('slug_public')->unique();
            $table->string('tema')->default('default');

            $table->timestamps();

            $table->index('public');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_portofolios');
    }
};