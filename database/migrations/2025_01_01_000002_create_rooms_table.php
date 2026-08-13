<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10)->unique();
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('floor')->default(1);
            $table->decimal('size_sqm', 8, 2)->nullable();
            $table->string('view_type')->nullable();
            $table->string('bed_type')->nullable();
            $table->integer('max_occupancy')->default(2);
            $table->decimal('price_per_night', 12, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'reserved', 'occupied', 'cleaning', 'maintenance', 'out_of_service'])->default('available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
