<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();
            // Link to users table instead of storing customer contact fields directly
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('number_of_guests');
            $table->dateTime('reservation_date');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_reservations');
    }
};
