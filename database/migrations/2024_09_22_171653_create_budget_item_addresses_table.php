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
        Schema::create('budget_item_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_item_id')->constrained('budget_items')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('from_location_id')->constrained('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('from_date');
            $table->foreignId('back_location_id')->constrained('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('back_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_item_addresses');
    }
};
