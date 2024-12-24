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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->decimal('video_profit_rate', 5, 2)->nullable();
            $table->decimal('book_profit', 5, 2)->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('video_preview')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('specialization')->nullable();
            $table->foreignId('grade_id')->nullable();
            $table->timestamps();
        });

        Schema::create('teacher_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('locale');
            $table->string('bio')->nullable();
            $table->text('description')->nullable();
            $table->unique(['teacher_id', 'locale']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_translations');
        Schema::dropIfExists('teachers');
    }
};
