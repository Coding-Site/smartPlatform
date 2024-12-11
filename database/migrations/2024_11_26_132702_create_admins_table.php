<?php

use App\Models\Admin\Admin;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        $admin = Admin::create([
            "name"     => "admin",
            "email"    => "admin@admin.com",
            "password" => "123456",
            "phone"    => "01281949875"
        ]);

        dump('Use this data for admin login:', [
            'phone'    => $admin->phone,
            'password' => $admin->password
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
