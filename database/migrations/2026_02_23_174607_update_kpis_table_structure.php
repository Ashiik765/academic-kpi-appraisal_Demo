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
        Schema::table('kpis', function (Blueprint $table) {
            $table->renameColumn('item', 'criteria');
            $table->renameColumn('max_marks', 'weightage');
            $table->dropColumn('description');
        });
    }

    public function down()
    {
        Schema::table('kpis', function (Blueprint $table) {
            $table->renameColumn('criteria', 'item');
            $table->renameColumn('weightage', 'max_marks');
            $table->text('description')->nullable();
        });
    }
};
