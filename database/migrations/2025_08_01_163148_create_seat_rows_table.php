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
        Schema::create('seat_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('row_label'); // Ví dụ: A, B, C, D
            $table->enum('type', ['standard', 'vip'])->default('standard');
            $table->integer('total_seats')->default(0);
            $table->timestamps();
            
            // Index để tối ưu query
            $table->index(['room_id', 'row_label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_rows');
    }
};
