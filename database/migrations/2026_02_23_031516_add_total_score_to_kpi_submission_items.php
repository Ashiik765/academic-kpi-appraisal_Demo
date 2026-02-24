<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {

            $table->decimal('total_score', 8, 2)
                  ->nullable()
                  ->after('appraiser_score');

        });
    }

    public function down(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {

            $table->dropColumn('total_score');

        });
    }
};