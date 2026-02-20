<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kpi_submission_items', function (Blueprint $table) {

            $table->id();

            // Connect to submission
            $table->foreignId('submission_id')
                ->constrained('kpi_submissions')
                ->onDelete('cascade');

            // Connect to master KPI
            $table->foreignId('kpi_id')
                ->constrained()
                ->onDelete('cascade');

            // Staff self score
            $table->integer('self_score')->nullable();

            $table->integer('rating')->nullable();

            // Appraiser score
            $table->integer('appraiser_score')->nullable();

            // Uploaded evidence
            $table->string('evidence')->nullable();

            // Comment per item
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_submission_items');
    }
};
