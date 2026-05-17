<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('kategori_prestasi_id')
                ->constrained('kategori_prestasis')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('penyelenggara')->nullable();

            $table->enum('tingkat', [
                'kampus',
                'lokal',
                'regional',
                'nasional',
                'internasional',
            ])->default('kampus');

            $table->string('jenis_prestasi')->nullable();
            $table->date('tanggal_prestasi')->nullable();

            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'published',
            ])->default('submitted');

            $table->boolean('ditampilkan')->default(false);

            $table->timestamp('diajukan_pada')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->timestamp('ditolak_pada')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['kategori_prestasi_id', 'status']);
            $table->index(['tingkat', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};