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
        Schema::create('rekonsiliasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skpd_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rekening_id')->constrained()->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained()->cascadeOnDelete();
            $table->foreignId('validator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->decimal('nilai_skpd', 15, 2);
            $table->decimal('nilai_bpkad', 15, 2)->nullable();

            $table->enum('status', [
                'dalam_proses',
                'valid',
                'selisih',
                'belum_rekonsiliasi'
            ])->default('dalam_proses');

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekonsiliasi');
    }
};
