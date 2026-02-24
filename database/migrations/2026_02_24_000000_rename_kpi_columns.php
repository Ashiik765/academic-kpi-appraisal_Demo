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
        Schema::table('kpis', function (Blueprint $table) {
            // rename fields to match new naming
            if (Schema::hasColumn('kpis', 'item')) {
                $table->renameColumn('item', 'criteria');
            }

            if (Schema::hasColumn('kpis', 'max_marks')) {
                $table->renameColumn('max_marks', 'weightage');
            }

            // description column may not exist, but drop if it does
            if (Schema::hasColumn('kpis', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            if (Schema::hasColumn('kpis', 'criteria')) {
                $table->renameColumn('criteria', 'item');
            }
            if (Schema::hasColumn('kpis', 'weightage')) {
                $table->renameColumn('weightage', 'max_marks');
            }
            // we won't recreate description column as original schema may have dropped it intentionally
        });
    }
};