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
        Schema::create('kpi_submissions', function (Blueprint $table) {

            $table->id();

            // Staff who submits
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Appraisal year
            $table->year('year');

            // Overall submission status
            $table->string('status')->default('draft');
            // draft | submitted | approved

            // Total final score
            $table->integer('total_score')->nullable();

            // Appraiser overall comment
            $table->text('overall_comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_submissions');
    }

    
};
