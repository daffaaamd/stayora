<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned();
            $table->tinyInteger('room_rating')->unsigned()->nullable();
            $table->tinyInteger('service_rating')->unsigned()->nullable();
            $table->tinyInteger('cleanliness_rating')->unsigned()->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_moderated')->default(false);
            $table->timestamps();

            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
