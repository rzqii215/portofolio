<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_status_prestasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prestasi_id')
                ->constrained('prestasis')
                ->cascadeOnDelete();

            $table->foreignId('diubah_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('status_lama')->nullable();
            $table->string('status_baru');
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index(['prestasi_id', 'status_baru']);
            $table->index('diubah_oleh');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_prestasis');
    }
};