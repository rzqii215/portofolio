<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validasi_prestasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prestasi_id')
                ->constrained('prestasis')
                ->cascadeOnDelete();

            $table->foreignId('validator_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('status', [
                'approved',
                'rejected',
            ]);

            $table->text('catatan')->nullable();
            $table->timestamp('divalidasi_pada')->nullable();

            $table->timestamps();

            $table->index(['prestasi_id', 'status']);
            $table->index('validator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validasi_prestasis');
    }
};