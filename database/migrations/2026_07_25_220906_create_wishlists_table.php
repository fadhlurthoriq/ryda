<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // pembeli
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'vehicle_id']); // biar ga bisa wishlist ganda
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};