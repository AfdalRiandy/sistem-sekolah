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
        Schema::create('pendaftaran_acaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('acara_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['menunggu', 'disetujui', 'gagal'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Prevent duplicate registrations
            $table->unique(['user_id', 'acara_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_acaras');
    }
};