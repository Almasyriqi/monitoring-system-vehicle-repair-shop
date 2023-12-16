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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->nullable(); 
            $table->foreign('payment_id')->references('id')->on('payments'); 
            $table->unsignedBigInteger('part_id')->nullable(); 
            $table->foreign('part_id')->references('id')->on('parts'); 
            $table->integer('quantity')->default(0);
            $table->double('amount')->default(0)->comment('parts price * quantity');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
