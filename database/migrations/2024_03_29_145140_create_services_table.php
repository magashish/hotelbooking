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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('owner_id');
            $table->string('unit');
            $table->string('guest_name');
            $table->tinyInteger('checkin')->nullable()->default(0);
            $table->datetime('arrival_date');
            $table->time('arrival_time')->nullable();
            $table->time('unit_arrival_time')->nullable();
            $table->tinyInteger('checkout')->nullable()->default(0);
            $table->datetime('departure_date');  
            $table->time('unit_departure_time')->nullable();          
            $table->time('departure_time')->nullable();
            //$table->string('mastercode')->nullable();
            $table->string('old_room_code')->nullable();
            $table->string('room_code')->nullable();   
            $table->text('notes')->nullable();
            $table->tinyInteger('b2b')->nullable()->default(0);
            $table->integer('runner')->nullable(); 
            $table->integer('cleaner')->nullable(); 
            $table->date('carry_over_date')->nullable();       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
