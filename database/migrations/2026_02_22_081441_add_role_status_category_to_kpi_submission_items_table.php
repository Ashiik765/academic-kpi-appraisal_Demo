<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {

            // Role of the user (staff/appraiser/admin etc)
            $table->string('role')->after('self_score');

            // Category like Teaching, Research, Service, Leadership
            $table->dropColumn('category');

            // Status like Pending, Approved, Rejected
            $table->string('status')->default('Pending')->after('role');

        });
    }

    public function down(): void
    {
        Schema::table('kpi_submission_items', function (Blueprint $table) {

            $table->dropColumn(['role', 'category', 'status']);

        });
    }
};