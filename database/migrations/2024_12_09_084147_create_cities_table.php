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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deliver_price')->nullable();
            $table->timestamps();
        });

        Schema::create('city_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_translations');
        Schema::dropIfExists('cities');
    }
};
