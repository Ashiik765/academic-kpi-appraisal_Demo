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
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();

            $table->enum('category', [
                'teaching',
                'research',
                'internal',
                'learning'
            ]);

            $table->string('item');          // KPI title
            $table->text('description')->nullable();

            $table->integer('weight')->default(1);
            $table->integer('max_marks');

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->timestamps();
        });





    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};
