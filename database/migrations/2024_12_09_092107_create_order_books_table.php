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
        Schema::create('order_books', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('address');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mandub_id')->nullable();
            $table->enum('status', ['new', 'current','complate','finish'])->default('new');
            $table->string('total_price')->nullable(); /// books + deliver
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_books');
    }
};