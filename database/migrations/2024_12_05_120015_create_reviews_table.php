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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignid('teacher_id')->constrained()->cascadeOnDelete();
            $table->text('review')->nullable();
            $table->unsignedTinyInteger('rating')->default(1)->check('star >= 1 and star <= 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
