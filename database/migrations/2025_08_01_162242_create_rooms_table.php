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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('total_seats')->default(0);
            $table->integer('capacity')->default(0);
            $table->enum('type', ['standard', 'vip', 'imax'])->default('standard');
            $table->softDeletes();
            $table->timestamps();
            
            // Index để tối ưu query
            $table->index(['cinema_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
