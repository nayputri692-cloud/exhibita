<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('karya')) {
            return;
        }

        Schema::create('karya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->string('medium', 150);
            $table->string('kategori', 100);
            $table->string('gambar', 255)->nullable();
            $table->enum('status', ['SUBMITTED', 'ACCEPTED', 'REJECTED'])->default('SUBMITTED');
            $table->text('catatan')->nullable();
            $table->string('booth', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karya');
    }
};
