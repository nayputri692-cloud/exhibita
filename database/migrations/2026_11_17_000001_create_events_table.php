<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('events')) {
            return;
        }

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->text('deskripsi');
            $table->string('lokasi', 200);
            $table->date('tanggal');
            $table->string('kategori', 100);
            $table->string('poster', 255)->nullable();
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('PUBLISHED');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
