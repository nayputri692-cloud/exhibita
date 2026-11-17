<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('karya') && !Schema::hasColumn('karya', 'views')) {
            Schema::table('karya', function (Blueprint $table) {
                $table->unsignedInteger('views')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('karya', 'views')) {
            Schema::table('karya', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }
};
