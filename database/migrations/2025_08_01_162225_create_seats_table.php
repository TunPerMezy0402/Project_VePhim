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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('row_id')->nullable()->constrained('seat_rows')->onDelete('cascade');
            $table->string('seat_number'); // Ví dụ: A01, A02, B01, B02
            $table->enum('seat_chair', ['single', 'couple'])->default('single');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            // Index để tối ưu query
            $table->index(['room_id', 'seat_number']);
            $table->index(['row_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
