<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {
            $table->dropColumn(['category', 'criteria', 'weightage']);
        });
    }

    public function down(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->text('criteria')->nullable();
            $table->decimal('weightage', 8, 2)->nullable();
        });
    }
};