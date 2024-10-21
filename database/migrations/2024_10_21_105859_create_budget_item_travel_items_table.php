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
        Schema::create('budget_item_travel_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_item_travel_id')->constrained('budget_item_travel')->onDelete('cascade')->onUpdate('cascade');
            $table->string('plate');
            $table->date('start');
            $table->string('driver');
            $table->string('location');
            $table->date('end');
            $table->integer('distance');
            $table->integer('round');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_item_travel_items');
    }
};
