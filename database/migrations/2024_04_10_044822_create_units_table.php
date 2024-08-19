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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('owner_id');
            $table->integer('name');

            $table->integer('bedroom_type');
            $table->string('bed_size');
            $table->string('sofa_size');
            $table->string('master_code');
            $table->tinyInteger('room_code')->default(0);
            $table->time('checkin')->nullable();
            $table->time('checkout')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
