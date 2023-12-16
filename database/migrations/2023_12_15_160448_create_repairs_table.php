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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->nullable(); 
            $table->foreign('vehicle_id')->references('id')->on('vehicles'); 
            $table->unsignedBigInteger('mechanic_id')->nullable(); 
            $table->foreign('mechanic_id')->references('id')->on('mechanics'); 
            $table->text('issue');
            $table->date('repair_date');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('status')->default(1)->comment('1: In Progress, 2: Complete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
