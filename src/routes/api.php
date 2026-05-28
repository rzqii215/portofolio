<?php

use Illuminate\Support\Facades\Route;

Route::get('/health-check', function () {
    return response()->json([
        'success' => true,
        'message' => 'API E-Portofolio Prestasi Mahasiswa aktif.',
        'app' => config('app.name'),
        'environment' => app()->environment(),
        'documentation' => url('/docs/api'),
    ]);
});