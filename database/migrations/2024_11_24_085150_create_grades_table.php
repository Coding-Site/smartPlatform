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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('grade_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['grade_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_translations');
        Schema::dropIfExists('grades');
    }
};
