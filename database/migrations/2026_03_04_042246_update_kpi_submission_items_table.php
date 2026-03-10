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
        Schema::table('kpi_submission_items', function (Blueprint $table) {

            $table->string('category')->nullable();
            $table->text('criteria')->nullable();
            $table->decimal('weightage', 8, 2)->nullable();

            $table->decimal('staff_total', 8, 2)->nullable();
            $table->decimal('appraiser_total', 8, 2)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
