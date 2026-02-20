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
       Schema::create('staff_kpi_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->year('year');

            $table->float('teaching_total')->default(0);
            $table->float('research_total')->default(0);
            $table->float('service_total')->default(0);
            $table->float('learning_total')->default(0);
            $table->float('overall_total')->default(0);
            $table->float('percentage')->default(0);
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_kpi_results');
    }
};
